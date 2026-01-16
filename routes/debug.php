<?php

use Illuminate\Support\Facades\Route;
use App\Models\Asesi;
use Illuminate\Support\Facades\Auth;

// Debug route - REMOVE IN PRODUCTION
Route::get('/debug/acceptance-letter/{id_asesi}', function($id_asesi) {
    $asesi = Asesi::with(['skema', 'rincianAsesmen.hasilAsesmen'])->find($id_asesi);
    $user = Auth::user();
    
    if (!$asesi) {
        return response()->json(['error' => 'Asesi not found']);
    }
    
    $userAsesi = null;
    if ($user && $user->role === 'asesi') {
        $userAsesi = Asesi::where('id_user', $user->id_user)->first();
    }
    
    return response()->json([
        'asesi' => [
            'id_asesi' => $asesi->id_asesi,
            'nama' => $asesi->nama_asesi,
            'id_user' => $asesi->id_user,
        ],
        'user' => $user ? [
            'id_user' => $user->id_user,
            'role' => $user->role,
            'email' => $user->email,
        ] : null,
        'user_asesi' => $userAsesi ? [
            'id_asesi' => $userAsesi->id_asesi,
            'nama' => $userAsesi->nama_asesi,
        ] : null,
        'rincian_asesmen' => $asesi->rincianAsesmen ? [
            'id' => $asesi->rincianAsesmen->id_rincian_asesmen,
            'id_asesor' => $asesi->rincianAsesmen->id_asesor,
        ] : null,
        'hasil_asesmen' => $asesi->rincianAsesmen && $asesi->rincianAsesmen->hasilAsesmen->isNotEmpty() ? [
            'id' => $asesi->rincianAsesmen->hasilAsesmen->first()->id,
            'status' => $asesi->rincianAsesmen->hasilAsesmen->first()->status,
            'tanggal_selesai' => $asesi->rincianAsesmen->hasilAsesmen->first()->tanggal_selesai,
        ] : null,
        'authorization' => [
            'is_admin' => $user && $user->role === 'admin',
            'is_own_asesi' => $userAsesi && $userAsesi->id_asesi === $id_asesi,
            'can_download' => ($user && $user->role === 'admin') || ($userAsesi && $userAsesi->id_asesi === $id_asesi),
        ],
        'eligibility' => [
            'has_rincian' => $asesi->rincianAsesmen !== null,
            'has_hasil' => $asesi->rincianAsesmen && $asesi->rincianAsesmen->hasilAsesmen->isNotEmpty(),
            'is_kompeten' => $asesi->rincianAsesmen && $asesi->rincianAsesmen->hasilAsesmen->isNotEmpty() && $asesi->rincianAsesmen->hasilAsesmen->first()->status === 'kompeten',
        ],
    ]);
});
