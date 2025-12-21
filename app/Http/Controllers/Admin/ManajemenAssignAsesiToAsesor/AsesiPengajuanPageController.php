<?php

namespace App\Http\Controllers\Admin\ManajemenAssignAsesiToAsesor;

use App\Http\Controllers\Controller;
use App\Models\Asesor;
use App\Models\AsesiPengajuan;
use App\Models\Asesi;
use App\Models\ProgresAsesmen;
use App\Models\Skema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\PeriodeAsesmen;
use Illuminate\Support\Facades\DB;
use App\Models\BidangKompetensi;
use App\Models\User;
// tanda tangan admin
use App\Models\TandaTanganAdmin;

//json response
use Illuminate\Http\JSONResponse;
//auth
use Illuminate\Support\Facades\Auth;

//rincian asesmen
use App\Models\Event;
use App\Models\RincianAsesmen;



class AsesiPengajuanPageController extends Controller
{
    public function indexDataAsesi()
    {
        $today = Carbon::now()->toDateString();
        
        // Pisahkan data menjadi dua kategori
        $pengajuanBaru = AsesiPengajuan::where('status_rekomendasi', 'N/A')
                        ->where(function($query) {
                            $query->where('status', '!=', 'needs_revision')
                                  ->orWhereNull('status');
                        })
                        ->orderBy('created_at', 'desc')
                        ->paginate(5, ['*'], 'pengajuan_baru_page');
        
        // Ubah query untuk pengajuan revisi, tambahkan status baru
        $pengajuanRevisi = AsesiPengajuan::whereIn('status', ['needs_revision', 'revised_by_asesi'])
                       ->paginate(5, ['*'], 'pengajuan_revisi_page');
        
        // Get asesi who have not been assigned to any asesor
        $asesi = Asesi::whereNotIn('id_asesi', function($query) {
            $query->select('id_asesi')
                  ->from('rincian_asesmen');
        })->paginate(5);
        
        // Get active asesors
        $asesors = Asesor::where('status_asesor', 'Aktif')->get();
        
        // Get active events (where current date is within event date range)
        $activeEvents = Event::where('tanggal_mulai_event', '<=', $today)
                             ->where('tanggal_berakhir_event', '>=', $today)
                             ->orderBy('periode_pelaksanaan')
                             ->orderBy('tahun_pelaksanaan')
                             ->get();
        
        // Get all events for filter dropdown
        $allEvents = Event::orderBy('tahun_pelaksanaan', 'desc')
                          ->orderBy('periode_pelaksanaan', 'desc')
                          ->get();
        
        // Get assignment history
        $assignments = RincianAsesmen::with(['asesi', 'asesi.skema', 'asesor', 'event'])
                                     ->orderBy('created_at', 'desc')
                                     ->paginate(10, ['*'], 'assignments_page');
        
        // Get total count of asesi
        $totalAsesi = Asesi::count();
        
        $skema = Skema::all();
        $bidangKompetensi = BidangKompetensi::all();
        
        return view('home.home-admin.daftar-asesi', compact(
            'pengajuanBaru',
            'pengajuanRevisi',
            'asesi', 
            'asesors', 
            'activeEvents',
            'allEvents',
            'assignments',
            'totalAsesi',
            'skema', 
            'bidangKompetensi'
        ));
    }

    public function getAsesorByBidang($id_bidang)
    {
        $asesors = Asesor::where('status_asesor', 'Aktif')
                    ->where(function($query) use ($id_bidang) {
                        $query->whereJsonContains('daftar_bidang_kompetensi', $id_bidang)
                            ->orWhereJsonContains('daftar_bidang_kompetensi', (int)$id_bidang)
                            ->orWhereJsonContains('daftar_bidang_kompetensi', (string)$id_bidang);
                    })
                    ->get(['id_asesor', 'nama_asesor']);
                    
        return response()->json($asesors);
    }

    public function getAllAsesor()
    {
        $asesors = Asesor::where('status_asesor', 'Aktif')
                    ->get(['id_asesor', 'nama_asesor']);
        return response()->json($asesors);
    }

    /**
     * Request revision for a submission
     */
    public function requestRevision(Request $request, $id_pengajuan)
    {
        $request->validate([
            'revision_notes' => 'required|min:10',
            'sections_to_revise' => 'required|array',
            'sections_to_revise.*' => 'required|numeric|min:1|max:4',
        ], [
            'revision_notes.required' => 'Catatan revisi harus diisi',
            'revision_notes.min' => 'Catatan revisi minimal 10 karakter',
            'sections_to_revise.required' => 'Pilih minimal satu bagian yang perlu direvisi',
            'sections_to_revise.array' => 'Format bagian revisi tidak valid',
        ]);
        
        $asesiPengajuan = AsesiPengajuan::findOrFail($id_pengajuan);
        
        // Update status pengajuan
        $asesiPengajuan->status = 'needs_revision';
        $asesiPengajuan->revision_notes = $request->revision_notes;
        $asesiPengajuan->sections_to_revise = $request->sections_to_revise;
        $asesiPengajuan->save();
        
        return redirect()->route('admin.asesi.index')->with('success', 'Permintaan revisi telah dikirim ke asesi');
    }


    /**
     * Process asesi application with improved handling for different statuses
     */
    public function processAsesi(Request $request, $id_pengajuan)
    {
        try {
            \Log::info('Starting processAsesi for ID: ' . $id_pengajuan);
            
            $asesiPengajuan = AsesiPengajuan::findOrFail($id_pengajuan);
            $admin = auth()->user();
            
            // Get active signature for the admin
            $adminSignature = $admin->tandaTanganAktif()->first();
            if (!$adminSignature) {
                return redirect()->back()->with('error', 'Anda belum memiliki tanda tangan digital. Silakan atur tanda tangan Anda terlebih dahulu.');
            }
            
            // Record signing timestamp
            $asesiPengajuan->waktu_tanda_tangan = now();
            
            // Process based on action
            if($request->form_action == 'approve') {
                // Approve process
                $asesiPengajuan->status_rekomendasi = 'Diterima';
                $asesiPengajuan->status = 'approved';
                $asesiPengajuan->id_admin = $admin->id_user;
                
                // Create asesi record HANYA jika status approved
                try {
                    $asesi = Asesi::create([
                        'nama_asesi' => $asesiPengajuan->nama_user,
                        'tempat_tanggal_lahir' => $asesiPengajuan->tempat_tanggal_lahir,
                        'jenis_kelamin' => $asesiPengajuan->jenis_kelamin,
                        'kebangsaan' => $asesiPengajuan->kebangsaan,
                        'alamat_rumah' => $asesiPengajuan->alamat_rumah,
                        'kota_domisili' => $asesiPengajuan->kota_domisili,
                        'no_telp' => $asesiPengajuan->no_telp,
                        'email' => $asesiPengajuan->email,
                        'nim' => $asesiPengajuan->nim,
                        'id_user' => $asesiPengajuan->id_user,
                        'id_skema' => $asesiPengajuan->id_skema,
                        'file_kelengkapan_pemohon' => $asesiPengajuan->file_kelengkapan_pemohon,
                        'ttd_pemohon' => $asesiPengajuan->ttd_pemohon,
                        'status_pekerjaan' => $asesiPengajuan->status_pekerjaan,
                        'nama_perusahaan' => $asesiPengajuan->nama_perusahaan,
                        'jabatan' => $asesiPengajuan->jabatan,
                        'alamat_perusahaan' => $asesiPengajuan->alamat_perusahaan,
                        'no_telp_perusahaan' => $asesiPengajuan->no_telp_perusahaan,
                    ]);
                    
                    // Progress creation moved to assignAsesor method
                    
                    // Update user level to asesi
                    $user = User::find($asesiPengajuan->id_user);
                    if ($user) {
                        $user->update(['level' => 'asesi']);
                    }
                    
                } catch (\Exception $e) {
                    \Log::error('Failed to create Asesi record: ' . $e->getMessage());
                    return redirect()->back()->with('error', 'Gagal membuat data asesi: ' . $e->getMessage());
                }
                
                $message = 'Pengajuan asesi telah disetujui dan ditandatangani';
                
            } else if ($request->form_action == 'revise') {
                // Untuk revisi, gunakan method requestRevision yang sudah ada
                // Pastikan kita tidak memproses lebih lanjut setelah redirect
                return $this->requestRevision($request, $id_pengajuan);
            } else if ($request->form_action == 'reject') {
                // Reject process dengan validasi eksplisit
                $request->validate([
                    'alasan_penolakan' => 'required|min:10',
                ]);
                
                $asesiPengajuan->status_rekomendasi = 'Ditolak';
                $asesiPengajuan->status = 'rejected';
                $asesiPengajuan->alasan_penolakan = $request->alasan_penolakan;
                $asesiPengajuan->id_admin = $admin->id_user;
                
                $message = 'Pengajuan asesi telah ditolak dengan alasan yang diberikan';
            } else {
                // Jika action tidak dikenal
                return redirect()->back()->with('error', 'Aksi tidak valid. Silakan coba lagi.');
            }
            
            $asesiPengajuan->save();
            return redirect()->route('admin.asesi.index')->with('success', $message);
            
        } catch (\Exception $e) {
            \Log::error('Uncaught exception in processAsesi: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Create Progress Asesi
     */
    private function createProgressAsesi($id_asesi)
    {
        try {
            $asesi = Asesi::findOrFail($id_asesi);
            $now = Carbon::now()->format('d-m-Y H:i:s');
            
            // Create progress record with explicit apl01 completion
            ProgresAsesmen::create([
                'id_asesi' => $asesi->id_asesi,
                'apl01' => [
                    'completed' => true,
                    'completed_at' => $now
                ]
                // No need to explicitly set other fields as the model's booted method 
                // will initialize them with default values
            ]);
            
            \Log::info('Progress Asesi created for ID: ' . $id_asesi . ' with apl01 completed at ' . $now);
            return true;
        } catch (\Exception $e) {
            \Log::error('Failed to create Progress Asesi: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Show pengajuan detail with revision status
     */
    public function showPengajuanDetail($id_pengajuan)
    {
        $asesiPengajuan = AsesiPengajuan::findOrFail($id_pengajuan);
        $buktiKelengkapan = $asesiPengajuan->file_kelengkapan_pemohon ?? [];
        
        // Get admin signature if application is already signed
        $adminSignature = null;
        if ($asesiPengajuan->id_admin_ttd) {
            $tandaTangan = TandaTanganAdmin::find($asesiPengajuan->id_admin_ttd);
            if ($tandaTangan) {
                $adminSignature = $tandaTangan->file_tanda_tangan;
            }
        }
        
        return view('home.home-admin.detail-pengajuan', compact('asesiPengajuan', 'buktiKelengkapan', 'adminSignature'));
    }

    /**
     * Show asesi detail (for approved asesi)
     */
    public function showAsesiDetail($id_asesi)
    {
        $asesi = Asesi::with(['skema', 'progresAsesmen', 'rincianAsesmen.asesor', 'rincianAsesmen.event'])
            ->findOrFail($id_asesi);
        
        // Calculate progress
        $progressData = null;
        if ($asesi->progresAsesmen) {
            $progressData = $asesi->progresAsesmen->calculateProgress(true);
        }
        
        // Determine status
        $statusKompetensi = 'Belum Mulai';
        if ($progressData) {
            if ($progressData['progress_percentage'] >= 100) {
                $statusKompetensi = 'Kompeten';
            } elseif ($progressData['progress_percentage'] > 0) {
                $statusKompetensi = 'Masih Proses';
            }
        }
        
        // Get all skema for dropdown
        $skemas = Skema::orderBy('nama_skema')->get();
        
        return view('home.home-admin.detail-asesi', compact('asesi', 'progressData', 'statusKompetensi', 'skemas'));
    }

    /**
     * Show edit form for asesi
     */
    public function editAsesi($id_asesi)
    {
        $asesi = Asesi::with(['skema'])->findOrFail($id_asesi);
        $skemas = Skema::orderBy('nama_skema')->get();
        
        return view('home.home-admin.edit-asesi', compact('asesi', 'skemas'));
    }

    /**
     * Update asesi data
     */
    public function updateAsesi(Request $request, $id_asesi)
    {
        $request->validate([
            'nama_asesi' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'nim' => 'nullable|string|max:50',
            'tempat_tanggal_lahir' => 'nullable|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'kebangsaan' => 'nullable|string|max:100',
            'alamat_rumah' => 'nullable|string',
            'kota_domisili' => 'nullable|string|max:100',
            'no_telp' => 'nullable|string|max:20',
            'id_skema' => 'nullable|exists:skema,id_skema',
            'status_pekerjaan' => 'nullable|string|max:100',
            'nama_perusahaan' => 'nullable|string|max:255',
            'jabatan' => 'nullable|string|max:100',
            'alamat_perusahaan' => 'nullable|string',
            'no_telp_perusahaan' => 'nullable|string|max:20',
        ], [
            'jenis_kelamin.required' => 'Jenis kelamin harus dipilih',
            'jenis_kelamin.in' => 'Jenis kelamin tidak valid',
        ]);

        try {
            $asesi = Asesi::findOrFail($id_asesi);
            
            $asesi->update([
                'nama_asesi' => $request->nama_asesi,
                'email' => $request->email,
                'nim' => $request->nim,
                'tempat_tanggal_lahir' => $request->tempat_tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'kebangsaan' => $request->kebangsaan,
                'alamat_rumah' => $request->alamat_rumah,
                'kota_domisili' => $request->kota_domisili,
                'no_telp' => $request->no_telp,
                'id_skema' => $request->id_skema,
                'status_pekerjaan' => $request->status_pekerjaan,
                'nama_perusahaan' => $request->nama_perusahaan,
                'jabatan' => $request->jabatan,
                'alamat_perusahaan' => $request->alamat_perusahaan,
                'no_telp_perusahaan' => $request->no_telp_perusahaan,
            ]);

            return redirect()->route('admin.asesi.show', $id_asesi)
                ->with('success', 'Data asesi berhasil diperbarui');
        } catch (\Exception $e) {
            Log::error('Error updating asesi: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal memperbarui data asesi: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function assignAsesor(Request $request)
    {
        $request->validate([
            'id_asesor' => 'required|exists:asesor,id_asesor',
            'assign_asesi' => 'required|array|min:1',
            'assign_asesi.*' => 'exists:asesi,id_asesi',
            'id_event' => 'required|exists:event,id_event',
        ]);

        $asesorId = $request->input('id_asesor');
        $asesiIds = $request->input('assign_asesi');
        $eventId = $request->input('id_event');

        // Begin transaction to ensure data consistency
        DB::beginTransaction();
        try {
            // Create rincian_asesmen entries for each asesi
            foreach ($asesiIds as $asesiId) {
                // Create rincian asesmen record
                RincianAsesmen::create([
                    'id_asesi' => $asesiId,
                    'id_asesor' => $asesorId,
                    'id_event' => $eventId,
                ]);
                
                // Check if progress record exists, if not create it
                $progressExists = ProgresAsesmen::where('id_asesi', $asesiId)->exists();
                if (!$progressExists) {
                    $this->createProgressAsesi($asesiId);
                    \Log::info('Created progress record for asesi ID: ' . $asesiId . ' during asesor assignment');
                }
            }

            DB::commit();
            return redirect()->back()->with('success', 'Asesi berhasil di-assign ke asesor untuk event yang dipilih.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error in assignAsesor: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

}