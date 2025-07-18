<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Asesi;
use App\Models\Event;
use App\Models\AsesiPengajuan;
use App\Models\Skema;
use App\Models\Asesor;
use App\Models\UK;
use App\Models\AsesiUK;
use App\Models\AsesiApl02;
use App\Models\HasilAsesmen;

class AsesiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $asesi = Asesi::with('skema')->where('id_user', $user->id_user)->first();
        return view('home.home-asesi.home-asesi', compact('asesi'));
    }

    public function indexAssesi()
    {
        $user = Auth::user();
        $asesi = Asesi::where('id_user', $user->id_user)->first();

        if (!$asesi) {
            return redirect()->back()->with('error', 'Data Asesi tidak ditemukan.');
        }

        $today = now();
        $events = Event::where('tanggal_mulai_event', '<=', $today)
            ->where('tanggal_berakhir_event', '>=', $today)
            ->get();

        // Menggabungkan data dengan skema dan asesor
        $eventData = $events->map(function ($event) use ($asesi) {
            $skema = Skema::find($asesi->id_skema);
            $asesor = Asesor::find($asesi->id_asesor);

            return [
                'tanggal' => $event->tanggal_mulai_event->format('d-m-Y') . ' s/d ' . $event->tanggal_berakhir_event->format('d-m-Y'),
                'nama_event' => $event->nama_event,
                'tuk' => $event->tuk,
                'jenis_event' => $event->tipe_event,
                'nomor_peserta' => $asesi->id_asesi,
                'skema' => $skema ? $skema->nama_skema : 'Tidak ditemukan',
                'asesor' => $asesor ? $asesor->nama_asesor : 'Tidak ditemukan',
            ];
        });

        $hasilAsesmen = HasilAsesmen::join('rincian_asesmen', 'hasil_asesmen.id_rincian_asesmen', '=', 'rincian_asesmen.id_rincian_asesmen')
        ->join('asesi', 'rincian_asesmen.id_asesi', '=', 'asesi.id_asesi')
        ->where('asesi.id_user', $user->id_user)
        ->select('hasil_asesmen.id', 'hasil_asesmen.status', 'hasil_asesmen.tanggal_selesai')
        ->get();
        // dd($hasilAsesmen);

        return view('home.home-asesi.assesi', compact('eventData', 'hasilAsesmen'));
    }

    public function detailApl1($id)
    {
        // dd(Auth::user()->asesiPengajuan->admin);
        // Cari pengajuan berdasarkan id_user yang diberikan
        $asesiPengajuan = AsesiPengajuan::where('id_user', $id)->latest()->first();

        // Jika tidak ditemukan, kembalikan error 404
        if (!$asesiPengajuan) {
            abort(404, 'Data pengajuan tidak ditemukan');
        }

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


    public function asesmenMandiri()
    {
        $user = Auth::user();

        $asesi = Asesi::with(['skema', 'asesor'])
            ->where('id_user', $user->id_user)
            ->first();

        if (!$asesi) {
            return redirect()->back()->with('error', 'Data Asesi tidak ditemukan.');
        }

        // Ambil data unit kompetensi (UK) dari daftar_id_uk pada skema
        $id_skema = $asesi->id_skema;
        $daftar_id_uk = json_decode($asesi->skema->daftar_id_uk, true);

        // Perbaikan: Eager loading relasi elemenUK untuk mengambil elemen-elemen terkait
        $unitKompetensi = UK::with('elemen_uk')
            ->whereIn('id_uk', $daftar_id_uk)
            ->get();

        $today = now();
        $event = Event::whereDate('tanggal_mulai_event', '<=', $today)
            ->whereDate('tanggal_berakhir_event', '>=', $today)
            ->first();

        return view('home.home-asesi.APL-02.asesmen-mandiri', compact('asesi', 'event', 'today', 'unitKompetensi'));
    }


}
