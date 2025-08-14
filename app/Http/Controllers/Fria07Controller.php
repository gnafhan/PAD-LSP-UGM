<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fria07;
use App\Models\HasilAsesmen;
use App\Models\TandaTanganAsesor;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Fria07Controller extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_asesi' => 'required|string',
            'id_asesor' => 'required|string',
            'id_skema' => 'required|string',
            'id_event' => 'nullable|string',
            'id_rincian_asesmen' => 'nullable|string',
            'data_tambahan' => 'nullable|string', 
        ]);

        // Decode data_tambahan
        $dataTambahan = [];
        if (!empty($validated['data_tambahan'])) {
            $decoded = json_decode($validated['data_tambahan'], true);
            if (is_array($decoded)) {
                $dataTambahan = $decoded;
            }
        }

        $hasilAsesmen = HasilAsesmen::where('id_rincian_asesmen', $validated['id_rincian_asesmen'] ?? null)->first();
        //  create new hasilAsesmen
        if (!$hasilAsesmen) {
            $hasilAsesmen = new HasilAsesmen();
            $hasilAsesmen->id_rincian_asesmen = $validated['id_rincian_asesmen'] ?? null;
            $hasilAsesmen->save();
        }
        
        // Update hasil asesmen
        if (isset($dataTambahan["hasil"]) && 
            is_array($dataTambahan["hasil"]) && 
            !empty($dataTambahan["hasil"]) && 
            isset($dataTambahan["hasil"][0]) && 
            is_array($dataTambahan["hasil"][0]) && 
            isset($dataTambahan["hasil"][0]["value"])) {
            $hasilAsesmen->status = $dataTambahan["hasil"][0]["value"];
            $hasilAsesmen->tanggal_selesai = now();
            $hasilAsesmen->save();
        }

        $fria07 = Fria07::where('id_asesi', $validated['id_asesi'])
            ->where('id_asesor', $validated['id_asesor'])
            ->where('id_skema', $validated['id_skema'])
            ->where('id_event', $validated['id_event'] ?? null)
            ->where('id_rincian_asesmen', $validated['id_rincian_asesmen'] ?? null)
            ->first();

        if ($fria07) {
            // Update data lama
            $fria07->data_tambahan = $dataTambahan;
            $fria07->id_event = $validated['id_event'] ?? null;
            $fria07->id_rincian_asesmen = $validated['id_rincian_asesmen'] ?? null;
            $fria07->save();
        } else {
            // Insert baru
            $id_fria07 = Str::uuid()->toString();
            Fria07::create([
                'id_fria07' => $id_fria07,
                'id_asesi' => $validated['id_asesi'],
                'id_asesor' => $validated['id_asesor'],
                'id_skema' => $validated['id_skema'],
                'id_event' => $validated['id_event'] ?? null,
                'id_rincian_asesmen' => $validated['id_rincian_asesmen'] ?? null,
                'data_tambahan' => $dataTambahan,
            ]);
        }

        return redirect()->back()->with('success', 'Data FRIA07 berhasil disimpan.');
    }

    public function signAsesor(Request $request)
    {
        try {
            $validated = $request->validate([
                'fria07_id' => 'required|string',
                'signature_type' => 'required|string|in:asesor'
            ]);

            // Cari FRIA07 berdasarkan ID
            $fria07 = Fria07::find($validated['fria07_id']);
            if (!$fria07) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data FRIA07 tidak ditemukan'
                ], 404);
            }

            // Verifikasi asesor yang sedang login
            $currentAsesorId = Auth::user()->asesor->id_asesor ?? null;
            if (!$currentAsesorId || $currentAsesorId !== $fria07->id_asesor) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Anda tidak memiliki akses untuk menandatangani formulir ini'
                ], 403);
            }

            // Cek apakah sudah ditandatangani
            if ($fria07->isAsesorSigned()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Formulir sudah ditandatangani sebelumnya'
                ], 400);
            }

            // Cari tanda tangan asesor yang aktif
            $tandaTanganAsesor = TandaTanganAsesor::where('id_asesor', $currentAsesorId)
                ->where(function($q) {
                    $q->whereNull('valid_until')->orWhere('valid_until', '>=', now());
                })
                ->orderByDesc('created_at')
                ->first();

            if (!$tandaTanganAsesor) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Tanda tangan asesor tidak ditemukan. Silakan upload tanda tangan di halaman biodata terlebih dahulu.'
                ], 400);
            }

            // Update waktu tanda tangan asesor
            $fria07->waktu_tanda_tangan_asesor = now();
            $fria07->save();

            Log::info('FRIA07 signed by asesor', [
                'fria07_id' => $fria07->id_fria07,
                'asesor_id' => $currentAsesorId,
                'signed_at' => $fria07->waktu_tanda_tangan_asesor
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Formulir berhasil ditandatangani',
                'data' => [
                    'ttd_asesor' => $tandaTanganAsesor->file_tanda_tangan,
                    'waktu_tanda_tangan_asesor' => $fria07->waktu_tanda_tangan_asesor
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error signing FRIA07', [
                'error' => $e->getMessage(),
                'request' => $request->all()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menandatangani formulir: ' . $e->getMessage()
            ], 500);
        }
    }
}
