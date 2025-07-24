<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fria01;
use Illuminate\Support\Str;

class Fria01Controller extends Controller
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

        $fria01 = Fria01::where('id_asesi', $validated['id_asesi'])
            ->where('id_asesor', $validated['id_asesor'])
            ->where('id_skema', $validated['id_skema'])
            ->where('id_event', $validated['id_event'] ?? null)
            ->where('id_rincian_asesmen', $validated['id_rincian_asesmen'] ?? null)
            ->first();

        if ($fria01) {
            // Update data lama
            $fria01->data_tambahan = $dataTambahan;
            $fria01->id_event = $validated['id_event'] ?? null;
            $fria01->id_rincian_asesmen = $validated['id_rincian_asesmen'] ?? null;
            $fria01->save();
        } else {
            // Insert baru
            $id_fria01 = Str::uuid()->toString();
            Fria01::create([
                'id_fria01' => $id_fria01,
                'id_asesi' => $validated['id_asesi'],
                'id_asesor' => $validated['id_asesor'],
                'id_skema' => $validated['id_skema'],
                'id_event' => $validated['id_event'] ?? null,
                'id_rincian_asesmen' => $validated['id_rincian_asesmen'] ?? null,
                'data_tambahan' => $dataTambahan,
            ]);
        }

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Data FRIA01 berhasil disimpan.');
    }
    
}
