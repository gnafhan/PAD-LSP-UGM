<?php

namespace App\Http\Controllers\Admin\ManajemenPengguna;

use App\Http\Controllers\Controller;
use App\Models\Asesor;
use App\Models\BidangKompetensi;
use App\Models\KompetensiTeknis;
use App\Models\TandaTanganAsesor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AsesorController extends Controller
{

    /**
     * Show the form for creating a new asesor.
     */
    public function create()
    {
        $bidangKompetensi = BidangKompetensi::all();
        return view('home.home-admin.tambah-asesor', compact('bidangKompetensi'));
    }

    /**
     * Store a newly created asesor.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_asesor' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:250',
                Rule::unique('users', 'email'), // Check uniqueness in users table
                Rule::unique('asesor', 'email'), // Check uniqueness in asesor table
                'regex:/^[a-zA-Z0-9._%+-]+@(mail\.ugm\.ac\.id|ugm\.ac\.id)$/'
            ],
            'no_hp_asesor' => 'required|string|max:20',
            'no_ktp' => 'nullable|string|max:20',
            'kode_registrasi' => 'nullable|string|max:100',
            'no_sertifikat' => 'nullable|string|max:100',
            'file_sertifikat_asesor' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'status_asesor' => 'required|in:Aktif,Tidak',
            'masa_berlaku' => 'required|date',
            'bidang_kompetensi' => 'required|string',
            'no_met' => 'nullable|string|max:100',
        ], [
            'nama_asesor.required' => 'Nama asesor tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'email.regex' => 'Email harus menggunakan email resmi UGM (@mail.ugm.ac.id atau @ugm.ac.id).',
            'email.unique' => 'Email sudah digunakan.',
            'status_asesor.required' => 'Status asesor harus dipilih',
            'masa_berlaku.required' => 'Tanggal masa berlaku wajib diisi',
            'no_hp_asesor.required' => 'Nomor HP asesor tidak boleh kosong.',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
    
        try {
            DB::beginTransaction();

            // 1. Create User
            $user = User::create([
                'name' => $request->nama_asesor,
                'email' => $request->email,
                'no_hp' => $request->no_hp_asesor,
                'password' => Hash::make(Str::random(12)), // Generate random password
                'level' => 'asesor',
            ]);
    
            // Proses bidang kompetensi
            $bidangKompetensiIds = [];
            if ($request->filled('bidang_kompetensi')) {
                $bidangKompetensiIds = json_decode($request->bidang_kompetensi, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    // Handle invalid JSON, perhaps set to empty array or throw error
                    $bidangKompetensiIds = [];
                    Log::warning('Invalid JSON for bidang_kompetensi during asesor store: ' . $request->bidang_kompetensi);
                }
            }
    
            // Proses upload file sertifikat
            $fileSertifikat = $this->uploadFileSertifikat($request);
    
            // 2. Buat data asesor
            // Assuming Asesor model's boot method handles id_asesor generation
            $asesor = Asesor::create([
                'id_user' => $user->id_user, // Link to the created user
                'nama_asesor' => $request->nama_asesor,
                'email' => $request->email,
                'no_hp' => $request->no_hp_asesor,
                'no_ktp' => $request->no_ktp,
                'kode_registrasi' => $request->kode_registrasi,
                'no_sertifikat' => $request->no_sertifikat,
                'no_met' => $request->no_met,
                'file_sertifikat_asesor' => $fileSertifikat,
                'status_asesor' => $request->status_asesor,
                'masa_berlaku' => $request->masa_berlaku,
                'alamat' => $request->alamat ?? '-', // Use provided alamat or default
                'daftar_bidang_kompetensi' => json_encode($bidangKompetensiIds)
            ]);
            
            DB::commit();
            return redirect()->route('admin.pengguna.index')
                ->with('success', 'Asesor berhasil ditambahkan');
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating asesor: ' . $e->getMessage() . ' at ' . $e->getFile() . ':' . $e->getLine());
            
            return redirect()->back()
                ->with('error', 'Gagal menambahkan asesor: ' . $e->getMessage())
                ->withInput();
        }
    }


   /**
     * Show the form for editing the asesor.
     */
    public function edit($id)
    {
        // ...existing code...
        $asesor = Asesor::with('user')->findOrFail($id); // Eager load user
        
        // Konversi daftar bidang kompetensi dari JSON ke array
        if (!empty($asesor->daftar_bidang_kompetensi)) {
            $bidangIds = is_array($asesor->daftar_bidang_kompetensi) ? $asesor->daftar_bidang_kompetensi : json_decode($asesor->daftar_bidang_kompetensi, true);
            
            // Ambil data lengkap bidang kompetensi dari ID
            $bidangKompetensiData = [];
            if (is_array($bidangIds)) {
                foreach ($bidangIds as $bidangId) {
                    $bidang = BidangKompetensi::find($bidangId);
                    if ($bidang) {
                        $bidangKompetensiData[] = [
                            'id' => $bidang->id_bidang_kompetensi,
                            'nama_bidang' => $bidang->nama_bidang
                        ];
                    }
                }
            }
            
            $asesor->bidang_kompetensi_data = $bidangKompetensiData; // Use a different property name to avoid conflict
        } else {
            $asesor->bidang_kompetensi_data = [];
        }
        
        // Ambil semua bidang kompetensi untuk dropdown
        $bidangKompetensi = BidangKompetensi::all();
        
        // Ambil data tanda tangan aktif
        $asesor->load('tandaTanganAktif');
        
        return view('home.home-admin.edit-asesor', compact('asesor', 'bidangKompetensi'));
    }

    /**
     * Update asesor data.
     * 
     */
    public function updateStatus(Request $request) // Changed from updateStatus and uses Route Model Binding
    {
        $validator = Validator::make($request->all(), [
            'id_asesor' => 'required|string',
            'status_asesor' => 'required|in:Aktif,Tidak',
            'masa_berlaku' => 'required|date',
            'bidang_kompetensi' => 'required|string', // Expecting JSON string of IDs
            'kode_registrasi' => 'nullable|string|max:100',
            'no_sertifikat' => 'nullable|string|max:100',
            'file_sertifikat_asesor' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
        ], [
            'status_asesor.required' => 'Status asesor harus dipilih.',
            'masa_berlaku.required' => 'Tanggal masa berlaku wajib diisi.',
            'bidang_kompetensi.required' => 'Bidang kompetensi tidak boleh kosong.',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        try {
            DB::beginTransaction();

            $asesor = Asesor::find($request->id_asesor);

            if (!$asesor) {
                return redirect()->back()
                    ->with('error', 'Asesor tidak ditemukan.')
                    ->withInput();
            }
            
            // Update bidang kompetensi
            $bidangKompetensiIds = [];
            if ($request->filled('bidang_kompetensi')) {
                $bidangKompetensiIds = json_decode($request->bidang_kompetensi, true);
                 if (json_last_error() !== JSON_ERROR_NONE) {
                    $bidangKompetensiIds = []; // or handle error
                    Log::warning('Invalid JSON for bidang_kompetensi during asesor update: ' . $request->bidang_kompetensi);
                }
            }
            
            // Upload file sertifikat jika ada
            $fileSertifikatPath = $asesor->file_sertifikat_asesor;
            if ($request->hasFile('file_sertifikat_asesor')) {
                // Hapus file lama jika ada
                if ($fileSertifikatPath && Storage::disk('public')->exists('sertifikat_asesor/' . $fileSertifikatPath)) {
                    Storage::disk('public')->delete('sertifikat_asesor/' . $fileSertifikatPath);
                }
                
                $file = $request->file('file_sertifikat_asesor');
                $fileName = 'asesor_' . Str::random(10) . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/sertifikat_asesor', $fileName);
                $fileSertifikatPath = $fileName;
            }
            
            // 2. Update data asesor
            $asesor->update([
                'status_asesor' => $request->status_asesor,
                'masa_berlaku' => $request->masa_berlaku,
                'daftar_bidang_kompetensi' => json_encode($bidangKompetensiIds),
                'kode_registrasi' => $request->kode_registrasi,
                'no_sertifikat' => $request->no_sertifikat,
                'file_sertifikat_asesor' => $fileSertifikatPath
            ]);
            
            DB::commit();
            
            return redirect()->route('admin.pengguna.index')
                ->with('success', 'Data asesor berhasil diperbarui');
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating asesor data: ' . $e->getMessage() . ' at ' . $e->getFile() . ':' . $e->getLine());
            
            return redirect()->back() // Redirect back on error for correction
                ->with('error', 'Gagal memperbarui data asesor: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the asesor detail.
     */
    public function show($id)
    {
        try {
            // Cari asesor berdasarkan ID
            $asesor = Asesor::findOrFail($id);
            
            // Enriching with bidang kompetensi
            $this->enrichAsesorWithBidangKompetensi($asesor);
            
            // Get sertifikat kompetensi teknis
            $sertifikat = KompetensiTeknis::where('id_asesor', $id)->get();
            
            // Get tanda tangan asesor
            $asesor->load('tandaTanganAktif');
            
            return view('home.home-admin.detail-asesor', compact('asesor', 'sertifikat'));
        } catch (\Exception $e) {
            return redirect()->route('admin.pengguna.index')
                ->with('error', 'Gagal memuat detail asesor: ' . $e->getMessage());
        }
    }

    /**
     * Helper method to get asesors by bidang kompetensi.
     */
    private function getAsesorsByBidangKompetensi($bidangId)
    {
        $filteredIds = [];
        $allAsesors = Asesor::all();
        
        foreach ($allAsesors as $asesor) {
            if (!empty($asesor->daftar_bidang_kompetensi)) {
                $bidangIds = json_decode($asesor->daftar_bidang_kompetensi, true);
                if (is_array($bidangIds) && in_array($bidangId, $bidangIds)) {
                    $filteredIds[] = $asesor->id_asesor;
                }
            }
        }
        
        return $filteredIds;
    }

    /**
     * Helper method to enrich asesors with bidang kompetensi.
     */
    private function enrichAsesorsWithBidangKompetensi($asesors)
    {
        $bidangKompetensiData = BidangKompetensi::all()->keyBy('id_bidang_kompetensi');
        
        foreach ($asesors as $asesor) {
            $bidangKompetensiList = [];
            
            if (!empty($asesor->daftar_bidang_kompetensi)) {
                $bidangIds = json_decode($asesor->daftar_bidang_kompetensi, true);
                
                foreach ($bidangIds as $idBidang) {
                    if (isset($bidangKompetensiData[$idBidang])) {
                        $bidangKompetensiList[] = [
                            'id' => $idBidang,
                            'nama_bidang' => $bidangKompetensiData[$idBidang]->nama_bidang
                        ];
                    }
                }
            }
            
            $asesor->bidang_kompetensi = $bidangKompetensiList;
        }
    }

    /**
     * Helper method to enrich a single asesor with bidang kompetensi.
     */
    private function enrichAsesorWithBidangKompetensi($asesor)
    {
        $bidangKompetensiData = BidangKompetensi::all()->keyBy('id_bidang_kompetensi');
        log::info($bidangKompetensiData);
        $bidangKompetensiList = [];
        log::info($asesor->daftar_bidang_kompetensi);
        if (!empty($asesor->daftar_bidang_kompetensi)) {
            log::info('Bidang kompetensi ditemukan');
            $bidangIds = $asesor->daftar_bidang_kompetensi;            
            foreach ($bidangIds as $idBidang) {
                if (isset($bidangKompetensiData[$idBidang])) {
                    $bidangKompetensiList[] = [
                        'id' => $idBidang,
                        'nama_bidang' => $bidangKompetensiData[$idBidang]->nama_bidang
                    ];
                    log::info('Bidang kompetensi: ' . $bidangKompetensiData[$idBidang]->nama_bidang);
                }
            }
        }

        
        $asesor->bidang_kompetensi = $bidangKompetensiList;
    }

    /**
     * Helper method to upload sertifikat file.
     */
    private function uploadFileSertifikat(Request $request)
    {
        if (!$request->hasFile('file_sertifikat_asesor')) {
            return null;
        }
        
        $file = $request->file('file_sertifikat_asesor');
        $fileName = 'asesor_' . Str::random(10) . '_' . time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/sertifikat_asesor', $fileName);
        
        return $fileName;
    }
}