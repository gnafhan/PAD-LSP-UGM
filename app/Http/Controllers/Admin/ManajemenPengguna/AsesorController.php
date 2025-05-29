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
                'unique:asesor',
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
        ], [
            'nama_asesor.required' => 'Nama asesor tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'email.regex' => 'Email harus menggunakan email resmi UGM (@mail.ugm.ac.id atau @ugm.ac.id).',
            'email.unique' => 'Email sudah digunakan',
            'status_asesor.required' => 'Status asesor harus dipilih',
            'masa_berlaku.required' => 'Tanggal masa berlaku wajib diisi',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
    
        try {
            DB::beginTransaction();
    
            // Proses bidang kompetensi
            $bidangKompetensiIds = [];
            if ($request->filled('bidang_kompetensi')) {
                $bidangKompetensiIds = json_decode($request->bidang_kompetensi, true);
            }
    
            // Proses upload file sertifikat
            $fileSertifikat = $this->uploadFileSertifikat($request);
    
            // Buat data asesor
            $asesor = Asesor::create([
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
                'alamat' => '-', // Required field with default
                'daftar_bidang_kompetensi' => json_encode($bidangKompetensiIds)
            ]);
            
            DB::commit();
            return redirect()->route('admin.pengguna.index')
                ->with('success', 'Asesor berhasil ditambahkan');
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating asesor: ' . $e->getMessage());
            
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
        $asesor = Asesor::findOrFail($id);
        
        // Konversi daftar bidang kompetensi dari JSON ke array
        if (!empty($asesor->daftar_bidang_kompetensi)) {
            $bidangIds = json_decode($asesor->daftar_bidang_kompetensi, true);
            
            // Ambil data lengkap bidang kompetensi dari ID
            $bidangKompetensiData = [];
            foreach ($bidangIds as $bidangId) {
                $bidang = BidangKompetensi::find($bidangId);
                if ($bidang) {
                    $bidangKompetensiData[] = [
                        'id' => $bidang->id_bidang_kompetensi,
                        'nama_bidang' => $bidang->nama_bidang
                    ];
                }
            }
            
            $asesor->bidang_kompetensi = $bidangKompetensiData;
        } else {
            $asesor->bidang_kompetensi = [];
        }
        
        // Ambil semua bidang kompetensi untuk dropdown
        $bidangKompetensi = BidangKompetensi::all();
        
        // Ambil data tanda tangan aktif
        $asesor->load('tandaTanganAktif');
        
        return view('home.home-admin.edit-asesor', compact('asesor', 'bidangKompetensi'));
    }

    /**
     * Update asesor status.
     */
    public function updateStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_asesor' => 'required|string',
            'status_asesor' => 'required|in:Aktif,Tidak',
            'masa_berlaku' => 'required|date',
            'bidang_kompetensi' => 'required|string',
            'kode_registrasi' => 'nullable|string|max:100',
            'no_sertifikat' => 'nullable|string|max:100',
            'file_sertifikat_asesor' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        try {
            DB::beginTransaction();
            
            // Cari asesor berdasarkan ID
            $asesor = Asesor::find($request->id_asesor);
            
            if (!$asesor) {
                return redirect()->route('admin.pengguna.index')
                    ->with('error', 'Asesor tidak ditemukan');
            }
            
            // Update bidang kompetensi
            $bidangKompetensiIds = [];
            if ($request->filled('bidang_kompetensi')) {
                $bidangKompetensiIds = json_decode($request->bidang_kompetensi, true);
            }
            
            // Upload file sertifikat jika ada
            $fileSertifikat = $asesor->file_sertifikat_asesor;
            if ($request->hasFile('file_sertifikat_asesor')) {
                // Hapus file lama jika ada
                if ($fileSertifikat && Storage::exists('public/sertifikat_asesor/' . $fileSertifikat)) {
                    Storage::delete('public/sertifikat_asesor/' . $fileSertifikat);
                }
                
                $file = $request->file('file_sertifikat_asesor');
                $fileName = 'asesor_' . Str::random(10) . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/sertifikat_asesor', $fileName);
                $fileSertifikat = $fileName;
            }
            
            // Update data asesor
            $asesor->update([
                'status_asesor' => $request->status_asesor,
                'masa_berlaku' => $request->masa_berlaku,
                'daftar_bidang_kompetensi' => json_encode($bidangKompetensiIds),
                'kode_registrasi' => $request->kode_registrasi,
                'no_sertifikat' => $request->no_sertifikat,
                'file_sertifikat_asesor' => $fileSertifikat
            ]);
            
            DB::commit();
            
            return redirect()->route('admin.pengguna.index')
                ->with('success', 'Data asesor berhasil diperbarui');
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating asesor data: ' . $e->getMessage());
            
            return redirect()->route('admin.pengguna.index')
                ->with('error', 'Gagal memperbarui data asesor: ' . $e->getMessage());
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
     * Delete asesor.
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            
            $asesor = Asesor::findOrFail($id);
            
            // Hapus file sertifikat asesor jika ada
            if (!empty($asesor->file_sertifikat_asesor)) {
                Storage::delete('public/sertifikat_asesor/' . $asesor->file_sertifikat_asesor);
            }
            
            // Hapus semua kompetensi teknis terkait
            $kompetensiTeknis = KompetensiTeknis::where('id_asesor', $id)->get();
            foreach ($kompetensiTeknis as $kt) {
                if (!empty($kt->file_sertifikat)) {
                    Storage::delete('public/sertifikat/' . $kt->file_sertifikat);
                }
                $kt->delete();
            }
            
            // Hapus semua tanda tangan terkait
            $tandaTangan = TandaTanganAsesor::where('id_asesor', $id)->get();
            foreach ($tandaTangan as $tt) {
                if (!empty($tt->file_tanda_tangan)) {
                    Storage::delete('public/tanda_tangan/' . $tt->file_tanda_tangan);
                }
                $tt->delete();
            }
            
            // Hapus asesor
            $asesor->delete();
            
            DB::commit();
            
            return redirect()->route('admin.pengguna.index')
                ->with('success', 'Asesor berhasil dihapus');
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting asesor: ' . $e->getMessage());
            
            return redirect()->route('admin.pengguna.index')
                ->with('error', 'Gagal menghapus asesor: ' . $e->getMessage());
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