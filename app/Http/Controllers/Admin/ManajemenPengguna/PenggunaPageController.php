<?php

namespace App\Http\Controllers\Admin\ManajemenPengguna;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Asesor;
use App\Models\Asesi;
use App\Models\Skema;
use App\Models\Event;
use App\Models\BidangKompetensi;
use App\Services\ProgressTrackingService;
use Illuminate\Http\Request;

class PenggunaPageController extends Controller
{
    protected ProgressTrackingService $progressTrackingService;

    public function __construct(ProgressTrackingService $progressTrackingService)
    {
        $this->progressTrackingService = $progressTrackingService;
    }

    /**
     * Display a listing of all users.
     */
    public function index(Request $request)
    {
        // Ambil data admin dari tabel users
        $adminQuery = User::where('level', 'admin');
        
        // Ambil data asesor dari tabel asesor
        $asesorQuery = Asesor::query();
        
        // Ambil data asesi dari tabel asesi dengan relasi event melalui rincianAsesmen
        $asesiQuery = Asesi::with(['skema', 'progresAsesmen', 'rincianAsesmen.event', 'rincianAsesmen.hasilAsesmen']);
        
        // Filter pencarian admin
        if ($request->has('search_admin')) {
            $search = $request->search_admin;
            
            $adminQuery->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('no_hp', 'LIKE', "%{$search}%");
            });
        }
        
        // Filter pencarian asesor
        if ($request->has('search_asesor')) {
            $search = $request->search_asesor;
            
            $asesorQuery->where(function($q) use ($search) {
                $q->where('nama_asesor', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('no_hp', 'LIKE', "%{$search}%");
            });
        }
        
        // Filter pencarian asesi
        if ($request->has('search_asesi')) {
            $search = $request->search_asesi;
            
            $asesiQuery->where(function($q) use ($search) {
                $q->where('nama_asesi', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('nim', 'LIKE', "%{$search}%");
            });
        }
        
        // Filter skema asesi
        if ($request->has('filter_skema_asesi') && $request->filter_skema_asesi != '') {
            $asesiQuery->where('id_skema', $request->filter_skema_asesi);
        }
        
        // Filter event asesi (melalui rincian_asesmen)
        if ($request->has('filter_event_asesi') && $request->filter_event_asesi != '') {
            $asesiQuery->whereHas('rincianAsesmen', function($q) use ($request) {
                $q->where('id_event', $request->filter_event_asesi);
            });
        }
        
        // Filter bidang kompetensi asesor
        if ($request->has('filter_bidang') && $request->filter_bidang != '') {
            // Kita perlu melakukan filter pada data JSON
            $filteredIds = [];
            $allAsesors = Asesor::all();
            
            foreach ($allAsesors as $asesor) {
                if (!empty($asesor->daftar_bidang_kompetensi)) {
                    // Tidak perlu json_decode karena accessor sudah mengembalikan array
                    $bidangIds = $asesor->daftar_bidang_kompetensi;
                    if (is_array($bidangIds) && in_array($request->filter_bidang, $bidangIds)) {
                        $filteredIds[] = $asesor->id_asesor;
                    }
                }
            }
            
            if (!empty($filteredIds)) {
                $asesorQuery->whereIn('id_asesor', $filteredIds);
            } else {
                // Jika tidak ada yang cocok, set query untuk tidak mengembalikan data
                $asesorQuery->whereRaw('1=0');
            }
        }
        
        // Mengambil data admin dan asesor
        $admins = $adminQuery->get();
        $asesors = $asesorQuery->get();
        $asesis = $asesiQuery->orderBy('created_at', 'desc')->get();
        
        // Calculate progress and status for each asesi
        foreach ($asesis as $asesi) {
            $progressData = $this->progressTrackingService->calculateSchemeBasedProgress($asesi->id_asesi);
            $asesi->setAttribute('progress_percentage', $progressData['progress_percentage']);
            
            // Get hasil asesmen from rincian asesmen
            $hasilAsesmen = null;
            if ($asesi->rincianAsesmen && $asesi->rincianAsesmen->hasilAsesmen->isNotEmpty()) {
                $hasilAsesmen = $asesi->rincianAsesmen->hasilAsesmen->first();
            }
            $asesi->setAttribute('hasil_asesmen', $hasilAsesmen);
        }
        
        // Get all bidang kompetensi for lookup
        $bidangKompetensiData = BidangKompetensi::all()->keyBy('id_bidang_kompetensi');
        
        // Add bidang kompetensi detail to each asesor
        foreach ($asesors as $asesor) {
            $bidangKompetensiList = [];
            
            if (!empty($asesor->daftar_bidang_kompetensi)) {
                // Tidak perlu json_decode karena accessor sudah mengembalikan array
                $bidangIds = $asesor->daftar_bidang_kompetensi;                
                foreach ($bidangIds as $idBidang) {
                    if (isset($bidangKompetensiData[$idBidang])) {
                        $bidangKompetensiList[] = [
                            'id' => $idBidang,
                            'nama_bidang' => $bidangKompetensiData[$idBidang]->nama_bidang
                        ];
                    }
                }
            }
            
            $asesor->setAttribute('bidang_kompetensi', $bidangKompetensiList);
        }
        
        // Hitung statistik
        $totalAsesi = Asesi::count();
        $totalStats = [
            'total' => User::count() + Asesor::count() + $totalAsesi,
            'admin' => User::where('level', 'admin')->count(),
            'asesor' => Asesor::count(),
            'asesor_aktif' => Asesor::where('status_asesor', 'aktif')->count(),
            'asesi' => $totalAsesi,
        ];
        
        // Get all bidang kompetensi for the dropdown in modal
        $bidangKompetensi = BidangKompetensi::getAllOrdered();
        
        // Get all skema for the dropdown filter
        $skemas = Skema::orderBy('nama_skema')->get();
        
        // Get all events for the dropdown filter
        $events = Event::orderBy('tahun_pelaksanaan', 'desc')
                       ->orderBy('periode_pelaksanaan', 'desc')
                       ->get();
        
        return view('home.home-admin.pengguna', compact('admins', 'asesors', 'asesis', 'totalStats', 'bidangKompetensi', 'skemas', 'events'));
    }

    /**
     * Show the create form.
     */
    public function create()
    {
        $bidangKompetensi = BidangKompetensi::getAllOrdered();
        return view('home.home-admin.tambah-pengguna', compact('bidangKompetensi'));
    }

    /**
     * Create a new bidang kompetensi via AJAX
     */
    public function createBidangKompetensi(Request $request)
    {
        try {
            $request->validate([
                'nama_bidang' => 'required|string|max:255|unique:bidang_kompetensi,nama_bidang'
            ], [
                'nama_bidang.required' => 'Nama bidang kompetensi tidak boleh kosong',
                'nama_bidang.unique' => 'Bidang kompetensi ini sudah ada'
            ]);

            $bidangKompetensi = BidangKompetensi::createBidangKompetensi($request->nama_bidang);

            return response()->json([
                'success' => true,
                'message' => 'Bidang kompetensi berhasil ditambahkan',
                'data' => [
                    'id' => $bidangKompetensi->id_bidang_kompetensi,
                    'nama' => $bidangKompetensi->nama_bidang
                ]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}