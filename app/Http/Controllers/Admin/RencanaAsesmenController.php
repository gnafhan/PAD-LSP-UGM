<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ElemenUK;
use App\Models\RencanaAsesmen;
use App\Models\Skema;
use App\Models\UK;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RencanaAsesmenController extends Controller
{
    /**
     * Display listing of rencana asesmen for a skema.
     */
    public function index($id_skema)
    {
        // Get skema details
        $skema = Skema::with('unitKompetensi')->findOrFail($id_skema);
        
        // Get unit kompetensi for this skema
        $unitKompetensi = $skema->unitKompetensi;
        
        // Count rencana asesmen for each UK
        $progressData = [];
        foreach ($unitKompetensi as $uk) {
            $totalElemenUK = ElemenUK::where('id_uk', $uk->id_uk)->count();
            $totalRencanaAsesmen = RencanaAsesmen::where('id_uk', $uk->id_uk)
                ->where('id_skema', $id_skema)
                ->count();
            
            $progressData[$uk->id_uk] = [
                'total_elemen' => $totalElemenUK,
                'total_rencana' => $totalRencanaAsesmen,
                'percentage' => $totalElemenUK > 0 ? round(($totalRencanaAsesmen / $totalElemenUK) * 100) : 0
            ];
        }
        
        // Get selected UK from query parameter or default to first
        $selectedUK = request('id_uk', $unitKompetensi->isNotEmpty() ? $unitKompetensi->first()->id_uk : null);
        
        // Get rencana asesmen for the selected UK only
        $rencanaAsesmen = $selectedUK ? RencanaAsesmen::where('id_uk', $selectedUK)
            ->where('id_skema', $id_skema)
            ->get() : collect();
            
        // Get elemen UK for the selected UK
        $elemenUK = $selectedUK ? ElemenUK::where('id_uk', $selectedUK)->get() : collect();
        
        // Get all rencana asesmen for this skema (for the preview table)
        $allRencanaAsesmen = RencanaAsesmen::where('id_skema', $id_skema)
            ->with('unitKompetensi')
            ->get();
        
        return view('home.home-admin.rencana-asesmen.index', compact(
            'skema', 
            'unitKompetensi', 
            'progressData', 
            'selectedUK', 
            'rencanaAsesmen',
            'elemenUK',
            'allRencanaAsesmen'
        ));
    }
    
    /**
     * Get rencana asesmen for a specific UK within a skema.
     */
    public function getByUK(Request $request, $id_skema, $id_uk)
    {
        $uk = UK::with('elemen_uk')->findOrFail($id_uk);
        $rencanaAsesmen = RencanaAsesmen::where('id_uk', $id_uk)
            ->where('id_skema', $id_skema)
            ->get();
            
        return response()->json([
            'uk' => $uk,
            'rencana_asesmen' => $rencanaAsesmen
        ]);
    }
    
    /**
     * Store a new rencana asesmen.
     */
    public function store(Request $request, $id_skema)
    {
        $validated = $request->validate([
            'id_uk' => 'required|exists:uk,id_uk',
            'elemen' => 'required|string',
            'bukti_bukti' => 'required|string',
            'jenis_bukti' => 'required|in:L,TL,T',
            'metode_dan_perangkat_asesmen' => 'required|in:CL,DIT,DPL,DPT,VP,CUP'
        ]);
        
        $rencanaAsesmen = new RencanaAsesmen();
        $rencanaAsesmen->id_skema = $id_skema;
        $rencanaAsesmen->id_uk = $validated['id_uk'];
        $rencanaAsesmen->elemen = $validated['elemen'];
        $rencanaAsesmen->bukti_bukti = $validated['bukti_bukti'];
        $rencanaAsesmen->jenis_bukti = $validated['jenis_bukti'];
        $rencanaAsesmen->metode_dan_perangkat_asesmen = $validated['metode_dan_perangkat_asesmen'];
        $rencanaAsesmen->save();
        
        return redirect()->route('admin.skema.rencana-asesmen.index', $id_skema)
            ->with('success', 'Rencana asesmen berhasil ditambahkan');
    }
    
    /**
     * Generate rencana asesmen from elemen UK.
     */
    public function generateFromElemen(Request $request, $id_skema, $id_uk)
    {
        $uk = UK::with('elemen_uk')->findOrFail($id_uk);
        $elemenUK = $uk->elemen_uk;
        
        if ($elemenUK->isEmpty()) {
            return redirect()->route('admin.skema.rencana-asesmen.index', ['id_skema' => $id_skema, 'id_uk' => $id_uk])
                ->with('warning', 'Tidak ada elemen UK untuk digenerate.');
        }
        
        DB::beginTransaction();
        try {
            $generatedCount = 0;
            foreach ($elemenUK as $elemen) {
                // Check if already exists
                $exists = RencanaAsesmen::where('id_skema', $id_skema)
                    ->where('id_uk', $id_uk)
                    ->where('elemen', $elemen->nama_elemen)
                    ->exists();
                    
                if (!$exists) {
                    RencanaAsesmen::create([
                        'id_skema' => $id_skema,
                        'id_uk' => $id_uk,
                        'elemen' => $elemen->nama_elemen,
                        'bukti_bukti' => 'Hasil Observasi ' . $elemen->nama_elemen,
                        'jenis_bukti' => 'L',
                        'metode_dan_perangkat_asesmen' => 'CL'
                    ]);
                    $generatedCount++;
                }
            }
            
            // Update skema completion status using helper method
            $this->updateSkemaCompletionStatus($id_skema);
            
            DB::commit();
            
            if ($generatedCount > 0) {
                return redirect()->route('admin.skema.rencana-asesmen.index', ['id_skema' => $id_skema, 'id_uk' => $id_uk])
                    ->with('success', "$generatedCount rencana asesmen berhasil digenerate dari elemen UK");
            } else {
                return redirect()->route('admin.skema.rencana-asesmen.index', ['id_skema' => $id_skema, 'id_uk' => $id_uk])
                    ->with('info', 'Semua elemen UK sudah memiliki rencana asesmen');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.skema.rencana-asesmen.index', ['id_skema' => $id_skema, 'id_uk' => $id_uk])
                ->with('error', 'Gagal generate rencana asesmen: ' . $e->getMessage());
        }
    }

    /**
     * Delete a rencana asesmen.
     */
    public function destroy($id_skema, $id_rencana_asesmen)
    {
        $rencanaAsesmen = RencanaAsesmen::findOrFail($id_rencana_asesmen);
        $id_uk = $rencanaAsesmen->id_uk;
        $rencanaAsesmen->delete();
        
        // Update skema completion status using helper method
        $this->updateSkemaCompletionStatus($id_skema);
        
        return redirect()->route('admin.skema.rencana-asesmen.index', ['id_skema' => $id_skema, 'id_uk' => $id_uk])
            ->with('success', 'Rencana asesmen berhasil dihapus');
    }

    /**
     * Helper method to check and update skema's completion status
     * based on the rencana asesmen data for all its UKs.
     */
    private function updateSkemaCompletionStatus($id_skema)
    {
        $skema = Skema::with('unitKompetensi')->findOrFail($id_skema);
        $isComplete = true;
        
        foreach ($skema->unitKompetensi as $uk) {
            $elemenCount = ElemenUK::where('id_uk', $uk->id_uk)->count();
            $rencanaCount = RencanaAsesmen::where('id_uk', $uk->id_uk)
                ->where('id_skema', $id_skema)
                ->count();
            
            // Jika ada UK yang belum memiliki rencana asesmen untuk semua elemennya
            if ($elemenCount > $rencanaCount) {
                $isComplete = false;
                break;
            }
        }
        
        // Update skema status
        $skema->has_complete_info = $isComplete;
        $skema->save();
        
        return $isComplete;
    }
}