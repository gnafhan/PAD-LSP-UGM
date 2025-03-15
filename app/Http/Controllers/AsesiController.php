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

        $unitKompetensi = UK::whereIn('id_uk', $daftar_id_uk)
            ->select('kode_uk', 'nama_uk', 'elemen_uk')
            ->get();

        $today = now();
        $event = Event::whereDate('tanggal_mulai_event', '<=', $today)
            ->whereDate('tanggal_berakhir_event', '>=', $today)
            ->first();

        return view('home.home-asesi.APL-02.asesmen-mandiri', compact('asesi', 'event', 'today', 'unitKompetensi'));
    }


}
