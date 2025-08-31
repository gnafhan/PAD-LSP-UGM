<?php

namespace App\Http\Controllers\Admin\ManajemenPengguna;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Asesor;
use App\Models\BidangKompetensi;
use Illuminate\Http\Request;

class PenggunaPageController extends Controller
{
    /**
     * Display a listing of all users.
     */
    public function index(Request $request)
    {
        // Ambil data admin dari tabel users
        $adminQuery = User::where('level', 'admin');
        
        // Ambil data asesor dari tabel asesor
        $asesorQuery = Asesor::query();
        
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
        $totalStats = [
            'total' => User::count() + Asesor::count(), // Total user (admin + asesor)
            'admin' => User::where('level', 'admin')->count(),
            'asesor' => Asesor::count(),
            'asesor_aktif' => Asesor::where('status_asesor', 'aktif')->count(),
        ];
        
        // Get all bidang kompetensi for the dropdown in modal
        $bidangKompetensi = BidangKompetensi::getAllOrdered();
        
        return view('home.home-admin.pengguna', compact('admins', 'asesors', 'totalStats', 'bidangKompetensi'));
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