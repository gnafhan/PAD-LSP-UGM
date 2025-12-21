<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Asesi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class CertificateUploadController extends Controller
{
    /**
     * Upload certificate for an asesi.
     * 
     * Requirements: 1.1, 1.2, 1.3, 1.4, 2.2, 2.3
     */
    public function upload(Request $request, string $id_asesi): JsonResponse
    {
        try {
            // Validate the request
            $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
                'certificate' => 'required|file|mimes:pdf|max:10240', // Max 10MB
            ], [
                'certificate.required' => 'File sertifikat harus diupload.',
                'certificate.mimes' => 'File harus berformat PDF.',
                'certificate.max' => 'Ukuran file maksimal 10MB.',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first(),
                ], 422);
            }

        // Find the asesi
        $asesi = Asesi::find($id_asesi);
        if (!$asesi) {
            return response()->json([
                'success' => false,
                'message' => 'Asesi tidak ditemukan.',
            ], 404);
        }

        // Delete old certificate if exists
        if ($asesi->file_sertifikat && Storage::disk('public')->exists($asesi->file_sertifikat)) {
            Storage::disk('public')->delete($asesi->file_sertifikat);
        }

        // Store the new certificate
        $file = $request->file('certificate');
        $filename = 'certificate_' . $id_asesi . '_' . time() . '.pdf';
        $path = $file->storeAs("certificates/{$id_asesi}", $filename, 'public');

        // Update asesi record
        $asesi->file_sertifikat = $path;
        $asesi->save();

        return response()->json([
            'success' => true,
            'message' => 'Sertifikat berhasil diupload.',
            'data' => [
                'file_path' => $path,
                'download_url' => route('admin.asesi.certificate.download', $id_asesi),
            ],
        ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Download certificate for an asesi.
     * 
     * Requirements: 2.1, 5.1
     */
    public function download(string $id_asesi): BinaryFileResponse|JsonResponse
    {
        $asesi = Asesi::find($id_asesi);
        
        if (!$asesi) {
            return response()->json([
                'success' => false,
                'message' => 'Asesi tidak ditemukan.',
            ], 404);
        }

        if (!$asesi->file_sertifikat || !Storage::disk('public')->exists($asesi->file_sertifikat)) {
            return response()->json([
                'success' => false,
                'message' => 'Sertifikat belum siap.',
            ], 404);
        }

        $filePath = storage_path('app/public/' . $asesi->file_sertifikat);
        $filename = 'Sertifikat_' . str_replace(' ', '_', $asesi->nama_asesi) . '.pdf';

        return response()->download($filePath, $filename);
    }

    /**
     * Delete certificate for an asesi.
     */
    public function delete(string $id_asesi): JsonResponse
    {
        $asesi = Asesi::find($id_asesi);
        
        if (!$asesi) {
            return response()->json([
                'success' => false,
                'message' => 'Asesi tidak ditemukan.',
            ], 404);
        }

        if ($asesi->file_sertifikat && Storage::disk('public')->exists($asesi->file_sertifikat)) {
            Storage::disk('public')->delete($asesi->file_sertifikat);
        }

        $asesi->file_sertifikat = null;
        $asesi->save();

        return response()->json([
            'success' => true,
            'message' => 'Sertifikat berhasil dihapus.',
        ]);
    }
}
