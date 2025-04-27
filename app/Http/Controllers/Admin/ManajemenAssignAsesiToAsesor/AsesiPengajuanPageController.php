<?php

namespace App\Http\Controllers\Admin\ManajemenAssignAsesiToAsesor;

use App\Http\Controllers\Controller;
use App\Models\Asesor;
use App\Models\AsesiPengajuan;
use App\Models\Asesi;
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
        
        // Get asesi pengajuan with N/A status
        $asesiPengajuan = AsesiPengajuan::where('status_rekomendasi', 'N/A')->paginate(5);
        
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
            'asesiPengajuan', 
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


    public function processAsesi(Request $request, $id_pengajuan)
    {
 
        try {
            \Log::info('Starting processAsesi for ID: ' . $id_pengajuan);
            \Log::info('Request data: ' . json_encode($request->all()));
            
            $asesiPengajuan = AsesiPengajuan::find($id_pengajuan);
    
            if(!$asesiPengajuan) {
                \Log::error('Asesi pengajuan not found with ID: ' . $id_pengajuan);
                return redirect()->back()->with('error', 'Data asesi pengajuan tidak ditemukan');
            }
    
            \Log::info('Found asesi pengajuan: ' . $asesiPengajuan->id_pengajuan);

            
            // Get current admin user
            $admin = auth()->user();
            \Log::info('Admin user: ' . $admin->id_user);
            
            // Get active signature for the admin
            $adminSignature = $admin->tandaTanganAktif()->first();
            \Log::info('Admin signature found: ' . ($adminSignature ? 'Yes' : 'No'));
            
            if (!$adminSignature) {
                \Log::warning('Admin has no active signature');
                return redirect()->back()->with('error', 'Anda belum memiliki tanda tangan digital. Silakan atur tanda tangan Anda terlebih dahulu.');
            }
            
            // Record signing timestamp
            $asesiPengajuan->waktu_tanda_tangan = now();
            //disini sesi masih ada
            
            // Process based on action (approve or reject)
            if($request->action == 'approve') {
                \Log::info('Processing approval action');

                // Approve process
                $asesiPengajuan->status_rekomendasi = 'Diterima';
                
                \Log::info('Creating new Asesi record from pengajuan data');
                
                // Create asesi record from the application
                try {
                    Asesi::create([
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
                    
                    \Log::info('Asesi record created successfully');
                } catch (\Exception $e) {
                    \Log::error('Failed to create Asesi record: ' . $e->getMessage());
                    \Log::error('Stack trace: ' . $e->getTraceAsString());
                    return redirect()->back()->with('error', 'Gagal membuat data asesi: ' . $e->getMessage());
                }
                
                // Store admin's signature reference - FIX: using id_user instead of user_id
                $asesiPengajuan->id_admin = $admin->id_user;
    
                // Update user level to asesi
                \Log::info('Updating user level to asesi for user: ' . $asesiPengajuan->id_user);
                $user = User::find($asesiPengajuan->id_user);
                if ($user) {
                    try {
                        $user->update(['level' => 'asesi']);
                        \Log::info('User level updated successfully');
                    } catch (\Exception $e) {
                        \Log::error('Failed to update user level: ' . $e->getMessage());
                    }
                } else {
                    \Log::warning('User not found for updating level: ' . $asesiPengajuan->id_user);
                }
                
                $message = 'Pengajuan asesi telah disetujui dan ditandatangani';
                
            } else {
                \Log::info('Processing rejection action');
                
                // Reject process
                $request->validate([
                    'alasan_penolakan' => 'required|min:10',
                ], [
                    'alasan_penolakan.required' => 'Alasan penolakan harus diisi',
                    'alasan_penolakan.min' => 'Alasan penolakan minimal 10 karakter',
                ]);
                
                $asesiPengajuan->status_rekomendasi = 'Ditolak';
                $asesiPengajuan->alasan_penolakan_pengajuan = $request->alasan_penolakan;
                
                // Store admin signature ID
                $asesiPengajuan->id_admin_ttd = $adminSignature->id;
                
                $message = 'Pengajuan asesi telah ditolak dengan alasan yang diberikan';
            }
            
            try {
                \Log::info('Saving updated asesi pengajuan');
                $asesiPengajuan->save();
                \Log::info('Asesi pengajuan saved successfully');
                
            } catch (\Exception $e) {
                \Log::error('Failed to save asesi pengajuan: ' . $e->getMessage());
                \Log::error('Stack trace: ' . $e->getTraceAsString());
                return redirect()->back()->with('error', 'Gagal menyimpan status pengajuan: ' . $e->getMessage());
            }

            // FIX: Correct route name
            \Log::info('Redirecting to admin.asesi.index with success message');
            return redirect()->route('admin.asesi.index')->with('success', $message);
            
        } catch (\Exception $e) {
            \Log::error('Uncaught exception in processAsesi: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Add this method for displaying the page with proper signature data
    public function showPengajuanDetail($id_pengajuan)
    {
        $asesiPengajuan = AsesiPengajuan::find($id_pengajuan);
        
        if(!$asesiPengajuan) {
            return redirect()->back()->with('error', 'Data asesi pengajuan tidak ditemukan');
        }
        
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

    public function approveAsesi($id_pengajuan)
    {
        $asesiPengajuan = AsesiPengajuan::find($id_pengajuan);

        if(!$asesiPengajuan) {
            return redirect()->back()->with('error', 'Data asesi pengajuan tidak ditemukan');
        }

        //Memindahkan data ke tabel Asesi
        Asesi::create([
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

        $asesiPengajuan->update(['status_rekomendasi' => 'Diterima']);

        $user = $asesiPengajuan->id_user;

        $userLevel = User::findOrFail($user);
        $userLevel->update(['level' => 'asesi']);

        return redirect()->route('admin.asesi.index')->with('success', 'Pengajuan asesi telah disetujui');
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
                RincianAsesmen::create([
                    'id_asesi' => $asesiId,
                    'id_asesor' => $asesorId,
                    'id_event' => $eventId,
                ]);
            }
    
            DB::commit();
            return redirect()->back()->with('success', 'Asesi berhasil di-assign ke asesor untuk event yang dipilih.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

}