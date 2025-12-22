<?php

namespace App\Http\Controllers\Asesor;

use App\Http\Controllers\Controller;
use App\Models\Asesi;
use App\Models\HasilAsesmen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HasilAsesmenController extends Controller
{
    public function index(Request $request){
        $asesor = Auth::user()->asesor;
        if($asesor){
            // Ambil semua asesi yang ditangani asesor, bukan hanya yang sudah ada hasil asesmen
            $hasilAsesmensQuery = DB::table('rincian_asesmen')
            ->join('asesi', 'rincian_asesmen.id_asesi', '=', 'asesi.id_asesi')
            ->join('skema', 'asesi.id_skema', '=', 'skema.id_skema')
            ->join('event', 'rincian_asesmen.id_event', '=', 'event.id_event')
            ->join('tuk', 'event.id_tuk', '=', 'tuk.id_tuk')
            ->leftJoin('hasil_asesmen', 'hasil_asesmen.id_rincian_asesmen', '=', 'rincian_asesmen.id_rincian_asesmen')
            ->where('rincian_asesmen.id_asesor', $asesor->id_asesor)
            ->select(
                'hasil_asesmen.id', 
                'hasil_asesmen.status', 
                'asesi.nama_asesi', 
                'asesi.id_asesi', 
                'skema.nama_skema', 
                'skema.nomor_skema', 
                'tuk.nama_tuk',
                'rincian_asesmen.id_rincian_asesmen'
            );
            
            if ($request->has('search') && $request->search !== null && trim($request->search) !== '') {
                $search = $request->search;
                $hasilAsesmensQuery->where(function($query) use ($search) {
                    $query->where('asesi.nama_asesi', 'like', "%$search%")
                          ->orWhere('skema.nama_skema', 'like', "%$search%")
                          ->orWhere('skema.nomor_skema', 'like', "%$search%")
                          ->orWhere('tuk.nama_tuk', 'like', "%$search%") ;
                });
            }
            $hasilAsesmens = $hasilAsesmensQuery->get();
            return view('home/home-asesor/hasil-asesmen', compact('hasilAsesmens'))->with('search', $request->search);
        }
        return redirect()->route('home-asesor');
    }

    /**
     * Menampilkan halaman create/edit hasil asesmen untuk asesor
     */
    public function create($id_rincian_asesmen)
    {
        $asesor = Auth::user()->asesor;
        if (!$asesor) {
            return redirect()->route('home-asesor')->with('error', 'Anda tidak memiliki akses sebagai asesor.');
        }

        // Cek apakah rincian asesmen ada dan ditangani oleh asesor ini
        $rincianAsesmen = DB::table('rincian_asesmen')
            ->join('asesi', 'rincian_asesmen.id_asesi', '=', 'asesi.id_asesi')
            ->join('skema', 'asesi.id_skema', '=', 'skema.id_skema')
            ->join('event', 'rincian_asesmen.id_event', '=', 'event.id_event')
            ->join('tuk', 'event.id_tuk', '=', 'tuk.id_tuk')
            ->where('rincian_asesmen.id_rincian_asesmen', $id_rincian_asesmen)
            ->where('rincian_asesmen.id_asesor', $asesor->id_asesor)
            ->select(
                'rincian_asesmen.id_rincian_asesmen',
                'asesi.id_asesi',
                'asesi.nama_asesi',
                'skema.nama_skema',
                'skema.nomor_skema',
                'tuk.nama_tuk'
            )
            ->first();

        if (!$rincianAsesmen) {
            return redirect()->route('asesor.hasil-asesmen.index')->with('error', 'Data rincian asesmen tidak ditemukan.');
        }

        // Create empty hasil asesmen object for the form
        $hasilAsesmen = (object)[
            'id' => null,
            'id_rincian_asesmen' => $id_rincian_asesmen,
            'status' => 'belum_ada_hasil',
            'rincianAsesmen' => (object)[
                'asesi' => (object)[
                    'nama_asesi' => $rincianAsesmen->nama_asesi,
                    'id_asesi' => $rincianAsesmen->id_asesi,
                    'skema' => (object)[
                        'nama_skema' => $rincianAsesmen->nama_skema,
                        'nomor_skema' => $rincianAsesmen->nomor_skema
                    ]
                ],
                'event' => (object)[
                    'tuk' => (object)[
                        'nama_tuk' => $rincianAsesmen->nama_tuk
                    ]
                ]
            ]
        ];

        return view('home.home-asesor.edit-hasil-asesmen', compact('hasilAsesmen'));
    }

    /**
     * Menampilkan halaman edit hasil asesmen untuk asesor
     */
    public function edit($id)
    {
        $asesor = Auth::user()->asesor;
        if (!$asesor) {
            return redirect()->route('home-asesor')->with('error', 'Anda tidak memiliki akses sebagai asesor.');
        }

        $hasilAsesmen = HasilAsesmen::with(['rincianAsesmen.asesi.skema', 'rincianAsesmen.event.tuk'])
            ->where('id', $id)
            ->whereHas('rincianAsesmen', function($query) use ($asesor) {
                $query->where('id_asesor', $asesor->id_asesor);
            })
            ->first();

        if (!$hasilAsesmen) {
            return redirect()->route('asesor.hasil-asesmen.index')->with('error', 'Data hasil asesmen tidak ditemukan.');
        }

        return view('home.home-asesor.edit-hasil-asesmen', compact('hasilAsesmen'));
    }

    /**
     * Store atau Update status hasil asesmen
     */
    public function store(Request $request)
    {
        $asesor = Auth::user()->asesor;
        if (!$asesor) {
            return redirect()->route('home-asesor')->with('error', 'Anda tidak memiliki akses sebagai asesor.');
        }

        $request->validate([
            'id_rincian_asesmen' => 'required|exists:rincian_asesmen,id_rincian_asesmen',
            'status' => 'required|in:kompeten,tidak_kompeten,belum_ada_hasil'
        ]);

        // Cek apakah rincian asesmen ditangani oleh asesor ini
        $rincianAsesmen = DB::table('rincian_asesmen')
            ->where('id_rincian_asesmen', $request->id_rincian_asesmen)
            ->where('id_asesor', $asesor->id_asesor)
            ->first();

        if (!$rincianAsesmen) {
            return redirect()->route('asesor.hasil-asesmen.index')->with('error', 'Data rincian asesmen tidak ditemukan.');
        }

        // Create new hasil asesmen
        $hasilAsesmen = HasilAsesmen::create([
            'id_rincian_asesmen' => $request->id_rincian_asesmen,
            'status' => $request->status,
            'tanggal_selesai' => $request->status !== 'belum_ada_hasil' ? now() : null
        ]);

        // Update progress asesmen
        $asesi = \App\Models\Asesi::where('id_asesi', $rincianAsesmen->id_asesi)->first();
        if ($asesi && $asesi->progresAsesmen) {
            $progres = $asesi->progresAsesmen;
            if ($request->status !== 'belum_ada_hasil') {
                $progres->completeStep('hasil_asesmen');
            }
        }

        return redirect()->route('asesor.hasil-asesmen.index')->with('success', 'Status hasil asesmen berhasil disimpan.');
    }

    /**
     * Update status hasil asesmen
     */
    public function update(Request $request, $id)
    {
        $asesor = Auth::user()->asesor;
        if (!$asesor) {
            return redirect()->route('home-asesor')->with('error', 'Anda tidak memiliki akses sebagai asesor.');
        }

        $request->validate([
            'status' => 'required|in:kompeten,tidak_kompeten,belum_ada_hasil'
        ]);

        $hasilAsesmen = HasilAsesmen::where('id', $id)
            ->whereHas('rincianAsesmen', function($query) use ($asesor) {
                $query->where('id_asesor', $asesor->id_asesor);
            })
            ->first();

        if (!$hasilAsesmen) {
            return redirect()->route('asesor.hasil-asesmen.index')->with('error', 'Data hasil asesmen tidak ditemukan.');
        }

        $hasilAsesmen->status = $request->status;
        
        // Set tanggal selesai jika status kompeten atau tidak kompeten
        if ($request->status !== 'belum_ada_hasil') {
            $hasilAsesmen->tanggal_selesai = now();
        } else {
            $hasilAsesmen->tanggal_selesai = null;
        }
        
        $hasilAsesmen->save();

        // Update progress asesmen hasil_asesmen field
        $asesi = $hasilAsesmen->rincianAsesmen->asesi;
        if ($asesi && $asesi->progresAsesmen) {
            $progres = $asesi->progresAsesmen;
            if ($request->status !== 'belum_ada_hasil') {
                $progres->completeStep('hasil_asesmen');
            } else {
                // Reset completion if status is set back to belum_ada_hasil
                $progres->hasil_asesmen = ['completed' => false, 'completed_at' => null];
                $progres->save();
            }
        }

        return redirect()->route('asesor.hasil-asesmen.index')->with('success', 'Status hasil asesmen berhasil diperbarui.');
    }
}
