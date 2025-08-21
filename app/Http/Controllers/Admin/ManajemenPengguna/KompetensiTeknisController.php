<?php

namespace App\Http\Controllers\Admin\ManajemenPengguna;

use App\Http\Controllers\Controller;
use App\Models\Asesor;
use App\Models\KompetensiTeknis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class KompetensiTeknisController extends Controller
{
    /**
     * Display a listing of the kompetensi teknis for an asesor.
     */
    public function index($id)
    {
        try {
            // Cari asesor berdasarkan ID
            $asesor = Asesor::findOrFail($id);
            
            // Get sertifikat kompetensi teknis dengan relasi bidangKompetensi
            $sertifikat = KompetensiTeknis::with('bidangKompetensi')->where('id_asesor', $id)->get();
            
            // Get bidang kompetensi yang dimiliki asesor (dari daftar_bidang_kompetensi)
            $asesor = Asesor::findOrFail($id);
            $bidangKompetensiIds = is_array($asesor->daftar_bidang_kompetensi) 
                ? $asesor->daftar_bidang_kompetensi 
                : json_decode($asesor->daftar_bidang_kompetensi, true);
            
            $bidangKompetensi = collect();
            if (is_array($bidangKompetensiIds)) {
                $bidangKompetensi = \App\Models\BidangKompetensi::whereIn('id_bidang_kompetensi', $bidangKompetensiIds)
                    ->orderBy('nama_bidang')
                    ->get();
            }
            
            // Buat mapping status sertifikat untuk setiap bidang
            $statusBidang = [];
            foreach ($bidangKompetensi as $bidang) {
                $statusBidang[$bidang->id_bidang_kompetensi] = $sertifikat->where('id_bidang_kompetensi', $bidang->id_bidang_kompetensi)->count() > 0;
            }
            
            return view('home.home-admin.kompetensi-asesor', compact('asesor', 'sertifikat', 'bidangKompetensi', 'statusBidang'));
        } catch (\Exception $e) {
            return redirect()->route('admin.pengguna.asesor.index')
                ->with('error', 'Gagal memuat data kompetensi asesor: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new kompetensi teknis.
     */
    public function create($id)
    {
        try {
            $asesor = Asesor::findOrFail($id);
            return view('home.home-admin.tambah-kompetensi', compact('asesor'));
        } catch (\Exception $e) {
            return redirect()->route('admin.pengguna.asesor.index')
                ->with('error', 'Gagal memuat form tambah kompetensi: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created kompetensi teknis.
     */
    public function store(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'id_bidang_kompetensi' => 'required|exists:bidang_kompetensi,id_bidang_kompetensi',
            'lembaga_sertifikasi' => 'required|string|max:255',
            'skema_kompetensi' => 'required|string|max:255',
            'masa_berlaku' => 'required|date',
            'file_sertifikat' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
        ], [
            'id_bidang_kompetensi.required' => 'Bidang kompetensi harus dipilih',
            'id_bidang_kompetensi.exists' => 'Bidang kompetensi yang dipilih tidak valid',
            'lembaga_sertifikasi.required' => 'Lembaga sertifikasi tidak boleh kosong',
            'skema_kompetensi.required' => 'Skema kompetensi tidak boleh kosong',
            'masa_berlaku.required' => 'Masa berlaku tidak boleh kosong',
            'masa_berlaku.date' => 'Format tanggal masa berlaku tidak valid',
            'file_sertifikat.file' => 'File sertifikat tidak valid',
            'file_sertifikat.mimes' => 'File sertifikat harus berformat PDF, JPG, JPEG, atau PNG',
        ]);
        
        if ($validator->fails()) {
            return redirect()->route('admin.pengguna.kompetensi.index', $id)
                ->withErrors($validator)
                ->withInput();
        }
        
        // Validasi custom: pastikan satu bidang hanya bisa diisi satu sertifikat
        $existingSertifikat = KompetensiTeknis::where('id_asesor', $id)
            ->where('id_bidang_kompetensi', $request->id_bidang_kompetensi)
            ->first();
            
        if ($existingSertifikat) {
            return redirect()->route('admin.pengguna.kompetensi.index', $id)
                ->withErrors(['id_bidang_kompetensi' => 'Bidang kompetensi ini sudah memiliki sertifikat'])
                ->withInput();
        }
        
        try {
            DB::beginTransaction();
            
            // Cari asesor berdasarkan ID
            $asesor = Asesor::findOrFail($id);
            
            // Upload file sertifikat jika ada
            $fileSertifikat = null;
            if ($request->hasFile('file_sertifikat')) {
                $file = $request->file('file_sertifikat');
                $fileName = 'kompetensi_' . Str::random(10) . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/sertifikat_kompetensi', $fileName);
                $fileSertifikat = $fileName;
            }
                        
            // Buat kompetensi teknis baru
            KompetensiTeknis::create([
                'id_asesor' => $asesor->id_asesor,
                'id_bidang_kompetensi' => $request->id_bidang_kompetensi,
                'lembaga_sertifikasi' => $request->lembaga_sertifikasi,
                'skema_kompetensi' => $request->skema_kompetensi,
                'masa_berlaku' => $request->masa_berlaku,
                'file_sertifikat' => $fileSertifikat
            ]);
            
            DB::commit();
            
            return redirect()->route('admin.pengguna.kompetensi.index', $id)
                ->with('success', 'Sertifikat kompetensi teknis berhasil ditambahkan');
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error adding sertifikat: ' . $e->getMessage());
            
            return redirect()->route('admin.pengguna.kompetensi.index', $id)
                ->with('error', 'Gagal menambahkan sertifikat: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified kompetensi teknis.
     */
    public function show($id, $kompetensiId)
    {
        try {
            $asesor = Asesor::findOrFail($id);
            $kompetensi = KompetensiTeknis::findOrFail($kompetensiId);
            
            if ($kompetensi->id_asesor !== $id) {
                return redirect()->route('admin.pengguna.kompetensi.index', $id)
                    ->with('error', 'Data kompetensi tidak ditemukan untuk asesor ini');
            }
            
            return view('home.home-admin.detail-kompetensi', compact('asesor', 'kompetensi'));
        } catch (\Exception $e) {
            return redirect()->route('admin.pengguna.kompetensi.index', $id)
                ->with('error', 'Gagal memuat detail kompetensi: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified kompetensi teknis.
     */
    public function edit($id, $kompetensiId)
    {
        try {
            $asesor = Asesor::findOrFail($id);
            $kompetensi = KompetensiTeknis::findOrFail($kompetensiId);
            
            if ($kompetensi->id_asesor !== $id) {
                return redirect()->route('admin.pengguna.kompetensi.index', $id)
                    ->with('error', 'Data kompetensi tidak ditemukan untuk asesor ini');
            }
            
            return view('home.home-admin.edit-kompetensi', compact('asesor', 'kompetensi'));
        } catch (\Exception $e) {
            return redirect()->route('admin.pengguna.kompetensi.index', $id)
                ->with('error', 'Gagal memuat form edit kompetensi: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified kompetensi teknis.
     */
    public function update(Request $request, $id, $kompetensiId)
    {
        $validator = Validator::make($request->all(), [
            'id_bidang_kompetensi' => 'nullable|exists:bidang_kompetensi,id_bidang_kompetensi',
            'lembaga_sertifikasi' => 'required|string|max:255',
            'skema_kompetensi' => 'required|string|max:255',
            'masa_berlaku' => 'required|date',
            'file_sertifikat' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
        ]);
        
        if ($validator->fails()) {
            return redirect()->route('admin.pengguna.kompetensi.edit', [$id, $kompetensiId])
                ->withErrors($validator)
                ->withInput();
        }
        
        try {
            DB::beginTransaction();
            
            $kompetensi = KompetensiTeknis::findOrFail($kompetensiId);
            
            if ($kompetensi->id_asesor !== $id) {
                return redirect()->route('admin.pengguna.kompetensi.index', $id)
                    ->with('error', 'Data kompetensi tidak ditemukan untuk asesor ini');
            }
            
            // Upload file sertifikat jika ada
            if ($request->hasFile('file_sertifikat')) {
                // Hapus file lama jika ada
                if (!empty($kompetensi->file_sertifikat)) {
                    Storage::delete('public/sertifikat_kompetensi/' . $kompetensi->file_sertifikat);
                }
                
                $file = $request->file('file_sertifikat');
                $fileName = 'kompetensi_' . Str::random(10) . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/sertifikat_kompetensi', $fileName);
                $kompetensi->file_sertifikat = $fileName;
            }
            
            $kompetensi->id_bidang_kompetensi = $request->id_bidang_kompetensi ?: null;
            $kompetensi->lembaga_sertifikasi = $request->lembaga_sertifikasi;
            $kompetensi->skema_kompetensi = $request->skema_kompetensi;
            $kompetensi->masa_berlaku = $request->masa_berlaku;
            $kompetensi->save();
            
            DB::commit();
            
            return redirect()->route('admin.pengguna.kompetensi.index', $id)
                ->with('success', 'Kompetensi teknis berhasil diperbarui');
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating kompetensi: ' . $e->getMessage());
            
            return redirect()->route('admin.pengguna.kompetensi.edit', [$id, $kompetensiId])
                ->with('error', 'Gagal memperbarui kompetensi: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified kompetensi teknis.
     */
    public function destroy($id, $kompetensiId)
    {
        try {
            DB::beginTransaction();
            
            // Cari sertifikat
            $kompetensi = KompetensiTeknis::findOrFail($kompetensiId);
            
            if ($kompetensi->id_asesor !== $id) {
                return redirect()->route('admin.pengguna.kompetensi.index', $id)
                    ->with('error', 'Data kompetensi tidak ditemukan untuk asesor ini');
            }
            
            // Hapus file jika ada
            if (!empty($kompetensi->file_sertifikat)) {
                Storage::delete('public/sertifikat_kompetensi/' . $kompetensi->file_sertifikat);
            }
            
            // Hapus data sertifikat
            $kompetensi->delete();
            
            DB::commit();
            
            return redirect()->route('admin.pengguna.kompetensi.index', $id)
                ->with('success', 'Sertifikat kompetensi teknis berhasil dihapus');
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting kompetensi: ' . $e->getMessage());
            
            return redirect()->route('admin.pengguna.kompetensi.index', $id)
                ->with('error', 'Gagal menghapus kompetensi: ' . $e->getMessage());
        }
    }
    
    /**
     * Get sertifikat data as JSON.
     */
    public function getSertifikatJson($id)
    {
        try {
            $asesor = Asesor::findOrFail($id);
            $sertifikat = KompetensiTeknis::where('id_asesor', $id)->get();
            
            return response()->json($sertifikat);
        } catch (\Exception $e) {
            Log::error('Error fetching sertifikat data: ' . $e->getMessage());
            return response()->json([], 500);
        }
    }
    
}