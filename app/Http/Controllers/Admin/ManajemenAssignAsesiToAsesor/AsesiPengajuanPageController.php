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

    public function detailDataAsesi($id)
    {
        $asesiPengajuan = AsesiPengajuan::findOrFail($id);
        $id_user = $asesiPengajuan->id_user;

        $buktiKelengkapan = [
            'ijazah' => asset('storage/uploads/bukti_pemohon/jenjang_siswa/bukti_jenjang_siswa_' . $id_user . '.pdf'),
            'rapor' => asset('storage/uploads/bukti_pemohon/transkrip/bukti_transkrip_' . $id_user . '.pdf'),
            'pengalaman_kerja' => asset('storage/uploads/bukti_pemohon/pengalaman_kerja/bukti_pengalaman_kerja_' . $id_user . '.pdf'),
            'magang' => asset('storage/uploads/bukti_pemohon/magang/bukti_magang_' . $id_user . '.pdf'),
            'ktp' => asset('storage/uploads/bukti_pemohon/ktp/bukti_ktp_' . $id_user . '.pdf'),
            'foto' => asset('storage/uploads/bukti_pemohon/foto/bukti_foto_' . $id_user . '.pdf')
        ];

        return view('home.home-admin.detail-pengajuan', compact('asesiPengajuan', 'buktiKelengkapan'));
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