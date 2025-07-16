<?php

namespace App\Http\Controllers;

use App\Models\JadwalMUK;
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

        return view('home.home-asesi.assesi', compact('eventData'));
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

    public function fria2()
    {
        $user = Auth::user();
//        @dd($user);
        $asesi = Asesi::where('id_user', $user->id_user)->first();

        if (!$asesi) {
            return redirect()->back()->with('error', 'Data Asesi tidak ditemukan.');
        }

        // Ambil skema & asesor dari relasi
        $skema = Skema::find($asesi->id_skema);
        $asesiPengajuan = AsesiPengajuan::where('id_user', $user->id_user)->first();

        // Jadwal pelaksanaan asesmen
        $jadwal = JadwalMUK::where('id_asesi', $asesi->id_asesi)->first();
        $asesor = Asesor::find($jadwal->id_asesor ?? null);

        // Siapkan data untuk view
        $data = [

            'nomor_peserta' => $asesi->id_asesi,
            'nomor_skema' => $skema ? $skema->nomor_skema : 'Tidak ditemukan',
            'nama_skema' => $skema ? $skema->nama_skema : 'Tidak ditemukan',
            'tujuan_asesi' => $asesiPengajuan ? $asesiPengajuan->tujuan_asesmen : 'Tidak ditemukan',
            'tanggal_asesi' => $jadwal ? $jadwal->waktu_jadwal : 'Tidak ditemukan',
            'nama_asesor' => $asesor ? $asesor->nama_asesor : 'Tidak ditemukan',
        ];

        return view('home/home-asesi/FRIA-02/fria2', compact('data'));
    }


}
