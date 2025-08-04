<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fria07;
use App\Models\HasilAsesmen;
use Illuminate\Support\Str;

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
        // if hasilAsesmen is null, create new hasilAsesmen
        if (!$hasilAsesmen) {
            $hasilAsesmen = new HasilAsesmen();
            $hasilAsesmen->id_rincian_asesmen = $validated['id_rincian_asesmen'] ?? null;
            $hasilAsesmen->save();
        }
        
        // Update hasil asesmen if evaluations exist - safe array access
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

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Data FRIA07 berhasil disimpan.');
    }
}
