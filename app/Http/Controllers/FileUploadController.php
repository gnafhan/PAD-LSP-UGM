<?php

namespace App\Http\Controllers;

use App\Models\IA02;
use App\Models\IA02Tugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
    /**
     * Upload task file
     */
    public function uploadTask(Request $request)
    {
        // Disable session flash to prevent serialization
        if (session()->isStarted()) {
            session()->forget('_flash');
            session()->forget('_old_input');
            session()->forget('errors');
        }

        try {
            // Basic auth check
            if (!Auth::check()) {
                return response()->json(['error' => 'Not authenticated'], 401);
            }

            $user = Auth::user();
            $asesi = $user->asesi ?? null;

            if (!$asesi) {
                return response()->json(['error' => 'Asesi not found'], 403);
            }

            // Get basic inputs
            $judulTugas = $request->input('judul_tugas', '');
            $jenisEvidence = $request->input('jenis_evidence', '');

            if (empty($judulTugas)) {
                return response()->json(['error' => 'Judul tugas required'], 422);
            }

            if ($jenisEvidence !== '3') {
                return response()->json(['error' => 'Only file upload supported'], 422);
            }

            if (!$request->hasFile('file_upload')) {
                return response()->json(['error' => 'File required'], 422);
            }

            $file = $request->file('file_upload');
            if (!$file->isValid()) {
                return response()->json(['error' => 'Invalid file'], 422);
            }

            // Extract file data immediately
            $originalName = $file->getClientOriginalName();
            $fileSize = $file->getSize();
            $fileExtension = strtolower($file->getClientOriginalExtension());

            // Simple validation
            $allowed = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'];
            if (!in_array($fileExtension, $allowed)) {
                return response()->json(['error' => 'File type not allowed'], 422);
            }

            if ($fileSize > 20 * 1024 * 1024) {
                return response()->json(['error' => 'File too large'], 422);
            }

            // Store file
            $filename = time() . '_' . uniqid() . '.' . $fileExtension;
            $path = $file->storeAs('tugas', $filename, 'public');

            if (!$path) {
                return response()->json(['error' => 'Failed to store file'], 500);
            }

            // Get IA02 data
            $ia02 = IA02::where('id_asesi', $asesi->id_asesi)->first();
            if (!$ia02) {
                Storage::disk('public')->delete($path);
                return response()->json(['error' => 'IA02 not found'], 404);
            }

            // Create record
            $tugas = IA02Tugas::create([
                'id_asesi' => $asesi->id_asesi,
                'id_asesor' => $ia02->id_asesor,
                'id_skema' => $ia02->id_skema,
                'judul_tugas' => $judulTugas,
                'jenis_evidence' => '3',
                'file_path' => $path,
                'file_name' => $originalName,
                'file_size' => $fileSize,
                'waktu_submit' => now(),
                'status' => 'submitted',
            ]);

            // Clear file reference
            $file = null;
            unset($file);

            return response()->json([
                'success' => true,
                'message' => 'File uploaded successfully!',
                'data' => [
                    'id' => $tugas->id,
                    'judul_tugas' => $tugas->judul_tugas,
                    'file_name' => $tugas->file_name,
                ]
            ]);

        } catch (\Exception $e) {
            if (isset($path)) {
                try {
                    Storage::disk('public')->delete($path);
                } catch (\Exception $ex) {
                    // Ignore cleanup errors
                }
            }

            return response()->json([
                'error' => 'System error: ' . $e->getMessage()
            ], 500);
        }
    }
}
