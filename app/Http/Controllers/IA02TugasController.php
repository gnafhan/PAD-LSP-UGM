<?php

namespace App\Http\Controllers;

use App\Models\IA02;
use App\Models\IA02Tugas;
use App\Models\Asesi;
use App\Models\Asesor;
use App\Models\Skema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class IA02TugasController extends Controller
{
    /**
     * Test upload method
     */
    public function uploadTask(Request $request)
    {
        // Basic response to test method works
        $response = [
            'success' => true,
            'message' => 'Upload method is working!',
            'timestamp' => now()->toDateTimeString(),
            'data' => [
                'method' => 'uploadTask',
                'has_file' => $request->hasFile('file_upload'),
                'title' => $request->input('judul_tugas', 'not provided'),
                'evidence_type' => $request->input('jenis_evidence', 'not provided'),
                'request_method' => $request->method(),
                'content_type' => $request->header('Content-Type', 'not provided')
            ]
        ];

        // If it's actually a file upload, handle it properly
        if ($request->hasFile('file_upload') && $request->input('judul_tugas')) {
            try {
                // Disable session flash to prevent serialization
                if (session()->isStarted()) {
                    session()->forget('_flash');
                    session()->forget('_old_input');
                    session()->forget('errors');
                }

                // Basic auth check
                if (!Auth::check()) {
                    return response()->json(['error' => 'Not authenticated'], 401);
                }

                $user = Auth::user();
                $asesi = $user->asesi ?? null;

                if (!$asesi) {
                    return response()->json(['error' => 'Asesi not found'], 403);
                }

                $file = $request->file('file_upload');
                $judulTugas = $request->input('judul_tugas');

                // Store file immediately
                $filename = time() . '_' . uniqid() . '.' . strtolower($file->getClientOriginalExtension());
                $path = $file->storeAs('tugas', $filename, 'public');

                if ($path) {
                    // Get IA02 data
                    $ia02 = IA02::where('id_asesi', $asesi->id_asesi)->first();
                    
                    if ($ia02) {
                        // Create record
                        $tugas = IA02Tugas::create([
                            'id_asesi' => $asesi->id_asesi,
                            'id_asesor' => $ia02->id_asesor,
                            'id_skema' => $ia02->id_skema,
                            'judul_tugas' => $judulTugas,
                            'jenis_evidence' => '3',
                            'file_path' => $path,
                            'file_name' => $file->getClientOriginalName(),
                            'file_size' => $file->getSize(),
                            'waktu_submit' => now(),
                            'status' => 'submitted',
                        ]);

                        $response['data']['file_uploaded'] = true;
                        $response['data']['task_id'] = $tugas->id;
                        $response['data']['file_path'] = $path;
                        $response['message'] = 'File uploaded and task created successfully!';
                    } else {
                        Storage::disk('public')->delete($path);
                        $response['data']['error'] = 'IA02 data not found';
                    }
                } else {
                    $response['data']['error'] = 'Failed to store file';
                }

                // Clear file reference immediately
                $file = null;
                unset($file);

            } catch (\Exception $e) {
                $response['data']['error'] = 'Exception: ' . $e->getMessage();
            }
        }

        return response()->json($response);
    }

    /**
     * Display the task submission form
     */
    public function soalPraktek()
    {
        try {
            Log::info('=== soalPraktek method started ===');
            Log::info('Request URL: ' . request()->fullUrl());
            Log::info('Request method: ' . request()->method());
            Log::info('Route name: ' . request()->route()->getName());
            
            // Get authenticated user's asesi data
            $user = Auth::user();
            Log::info('User retrieved', ['user_id' => $user ? $user->id_user : 'null']);
            
            $asesi = $user->asesi;
            Log::info('Asesi retrieved', ['asesi_id' => $asesi ? $asesi->id_asesi : 'null']);
            
            if (!$asesi) {
                Log::warning('No asesi data found for user');
                return redirect()->route('asesi.index')->with('error', 'Data asesi tidak ditemukan.');
            }

            // Get IA02 data for this asesi
            $data = IA02::where('id_asesi', $asesi->id_asesi)->first();
            Log::info('IA02 data retrieved', ['ia02_exists' => $data ? 'yes' : 'no']);
            
            if (!$data) {
                Log::warning('No IA02 data found for asesi');
                return redirect()->route('asesi.index')->with('error', 'Data IA02 tidak ditemukan.');
            }

            // Get submitted tasks for this asesi with debugging
            Log::info('Getting tasks for asesi: ' . $asesi->id_asesi);
            $tugasSubmitted = IA02Tugas::byAsesi($asesi->id_asesi)
                ->orderBy('created_at', 'desc')
                ->get();
            
            Log::info('Found ' . $tugasSubmitted->count() . ' tasks for asesi: ' . $asesi->id_asesi);
            Log::info('Task details: ', $tugasSubmitted->toArray());

            // Ensure tugasSubmitted is never null
            if (!$tugasSubmitted) {
                $tugasSubmitted = collect([]);
                Log::warning('tugasSubmitted was null, setting to empty collection');
            }

            Log::info('About to render view with tugasSubmitted count: ' . $tugasSubmitted->count());
            Log::info('=== soalPraktek method ending ===');
            
            return view('home.home-asesi.FRIA-02.soal-praktek-upload-jawaban', compact('data', 'tugasSubmitted'));

        } catch (\Exception $e) {
            Log::error('Error in soalPraktek: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            
            // Provide fallback data to prevent undefined variable errors
            $tugasSubmitted = collect([]);
            $data = null;
            
            return view('home.home-asesi.FRIA-02.soal-praktek-upload-jawaban', compact('data', 'tugasSubmitted'))
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Store a new task submission
     */
    public function store(Request $request)
    {
        // IMMEDIATELY disable session flash/old input to avoid serialization
        session()->forget('_flash');
        session()->forget('_old_input');
        
        try {
            Log::info('Store method started');
            
            // Get authenticated user's asesi data
            $user = Auth::user();
            $asesi = $user->asesi;
            
            if (!$asesi) {
                Log::error('Asesi data not found for user: ' . $user->id_user);
                if ($request->expectsJson()) {
                    return response()->json(['error' => 'Data asesi tidak ditemukan.'], 403);
                } else {
                    return redirect()->back()->with('error', 'Data asesi tidak ditemukan.');
                }
            }

            Log::info('Processing request for asesi: ' . $asesi->id_asesi);

            // Extract request data immediately
            $judulTugas = $request->input('judul_tugas');
            $jenisEvidence = $request->input('jenis_evidence');
            $teksJawaban = $request->input('teks_jawaban');
            $linkEksternal = $request->input('link_eksternal');
            
            Log::info('Request data extracted', [
                'judul_tugas' => $judulTugas,
                'jenis_evidence' => $jenisEvidence,
                'has_file' => $request->hasFile('file_upload')
            ]);

            // Validation rules
            $rules = [
                'judul_tugas' => 'required|string|max:255',
                'jenis_evidence' => 'required|in:1,2,3',
            ];

            // Dynamic validation based on evidence type
            if ($jenisEvidence == '1') {
                $rules['teks_jawaban'] = 'required|string';
            } elseif ($jenisEvidence == '2') {
                $rules['link_eksternal'] = 'required|url|max:500';
            } elseif ($jenisEvidence == '3') {
                $rules['file_upload'] = 'required|file|max:20480|mimes:pdf,doc,docx,jpg,jpeg,png,zip,rar';
            }

            // Custom validation without storing request in session
            if (empty($judulTugas)) {
                return response()->json(['error' => 'Judul tugas wajib diisi.'], 422);
            }
            
            if (!in_array($jenisEvidence, ['1', '2', '3'])) {
                return response()->json(['error' => 'Jenis evidence tidak valid.'], 422);
            }

            // Get IA02 data for foreign keys
            $ia02 = IA02::where('id_asesi', $asesi->id_asesi)->first();
            
            if (!$ia02) {
                if ($request->expectsJson()) {
                    return response()->json(['error' => 'Data IA02 tidak ditemukan.'], 404);
                } else {
                    return redirect()->back()->with('error', 'Data IA02 tidak ditemukan.');
                }
            }

            // Prepare data for insertion
            $tugasData = [
                'id_asesi' => $asesi->id_asesi,
                'id_asesor' => $ia02->id_asesor,
                'id_skema' => $ia02->id_skema,
                'judul_tugas' => $judulTugas,
                'jenis_evidence' => $jenisEvidence,
                'waktu_submit' => now(),
                'status' => 'submitted',
            ];

            // Handle different evidence types
            if ($jenisEvidence == '1') {
                // Teks Jawaban
                if (empty($teksJawaban)) {
                    return response()->json(['error' => 'Teks jawaban wajib diisi.'], 422);
                }
                $tugasData['teks_jawaban'] = $teksJawaban;
                
            } elseif ($jenisEvidence == '2') {
                // Link Eksternal
                if (empty($linkEksternal) || !filter_var($linkEksternal, FILTER_VALIDATE_URL)) {
                    return response()->json(['error' => 'Link eksternal tidak valid.'], 422);
                }
                $tugasData['link_eksternal'] = $linkEksternal;
                
            } elseif ($jenisEvidence == '3') {
                // Upload File - handle immediately
                if (!$request->hasFile('file_upload')) {
                    return response()->json(['error' => 'File upload wajib diisi.'], 422);
                }
                
                $file = $request->file('file_upload');
                
                if (!$file->isValid()) {
                    return response()->json(['error' => 'File upload tidak valid.'], 422);
                }
                
                // Extract all needed data from file object IMMEDIATELY
                $originalName = $file->getClientOriginalName();
                $fileExtension = $file->getClientOriginalExtension();
                $fileMimeType = $file->getMimeType();
                $fileSize = $file->getSize();
                
                // Validate file
                $allowedMimes = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png', 'zip', 'rar'];
                if (!in_array(strtolower($fileExtension), $allowedMimes)) {
                    return response()->json(['error' => 'Tipe file tidak diperbolehkan.'], 422);
                }
                
                if ($fileSize > 20480 * 1024) { // 20MB in bytes
                    return response()->json(['error' => 'Ukuran file terlalu besar (max 20MB).'], 422);
                }
                
                // Generate unique filename
                $filename = time() . '_' . Str::random(10) . '.' . $fileExtension;
                
                // Store file in storage/app/public/tugas folder
                $path = $file->storeAs('tugas', $filename, 'public');
                
                if (!$path) {
                    return response()->json(['error' => 'Gagal menyimpan file.'], 500);
                }
                
                // Use extracted values instead of accessing file object
                $tugasData['file_path'] = $path;
                $tugasData['file_name'] = $originalName;
                $tugasData['file_type'] = $fileMimeType;
                $tugasData['file_size'] = $fileSize;
                
                // Clear file reference immediately to avoid serialization issues
                $file = null;
                unset($file);
                
                Log::info('File processed successfully', [
                    'path' => $path,
                    'original_name' => $originalName,
                    'size' => $fileSize,
                ]);
            }

            // Create the task
            Log::info('About to create IA02Tugas');
            $tugas = IA02Tugas::create($tugasData);
            Log::info('Successfully created tugas with ID: ' . $tugas->id);

            // Return success response
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Tugas berhasil dikumpulkan!',
                    'data' => [
                        'id' => $tugas->id,
                        'judul_tugas' => $tugas->judul_tugas,
                        'jenis_evidence' => $tugas->jenis_evidence_text,
                        'status' => $tugas->status_text,
                        'waktu_submit' => $tugas->waktu_submit->format('d/m/Y H:i:s'),
                    ]
                ]);
            } else {
                // Regular form submission - redirect back with success message
                return redirect()->back()->with('success', 'Tugas berhasil dikumpulkan!');
            }

        } catch (\Exception $e) {
            Log::error('Exception in store method: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            
            // Clean up uploaded file if error occurs
            if (isset($path)) {
                Storage::disk('public')->delete($path);
            }

            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            } else {
                return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
            }
        }
    }

    /**
     * Display a specific task
     */
    public function show($id)
    {
        try {
            $user = Auth::user();
            $asesi = $user->asesi;
            
            if (!$asesi) {
                return response()->json(['error' => 'Data asesi tidak ditemukan.'], 403);
            }

            $tugas = IA02Tugas::where('id', $id)
                ->where('id_asesi', $asesi->id_asesi)
                ->first();

            if (!$tugas) {
                return response()->json(['error' => 'Tugas tidak ditemukan.'], 404);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $tugas->id,
                    'judul_tugas' => $tugas->judul_tugas,
                    'jenis_evidence' => $tugas->jenis_evidence_text,
                    'teks_jawaban' => $tugas->teks_jawaban,
                    'link_eksternal' => $tugas->link_eksternal,
                    'file_name' => $tugas->file_name,
                    'file_size' => $tugas->formatted_file_size,
                    'file_url' => $tugas->file_url,
                    'status' => $tugas->status_text,
                    'waktu_submit' => $tugas->waktu_submit ? $tugas->waktu_submit->format('d/m/Y H:i:s') : null,
                    'catatan_asesor' => $tugas->catatan_asesor,
                    'nilai' => $tugas->nilai,
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete a specific task
     */
    public function destroy($id)
    {
        try {
            $user = Auth::user();
            $asesi = $user->asesi;
            
            if (!$asesi) {
                return response()->json(['error' => 'Data asesi tidak ditemukan.'], 403);
            }

            $tugas = IA02Tugas::where('id', $id)
                ->where('id_asesi', $asesi->id_asesi)
                ->first();

            if (!$tugas) {
                return response()->json(['error' => 'Tugas tidak ditemukan.'], 404);
            }

            // Delete associated file if exists
            if ($tugas->hasFile()) {
                Storage::disk('public')->delete($tugas->file_path);
            }

            $tugas->delete();

            return response()->json([
                'success' => true,
                'message' => 'Tugas berhasil dihapus!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Download file attachment
     */
    public function downloadFile($id)
    {
        try {
            $user = Auth::user();
            $asesi = $user->asesi;
            
            if (!$asesi) {
                return redirect()->back()->with('error', 'Data asesi tidak ditemukan.');
            }

            $tugas = IA02Tugas::where('id', $id)
                ->where('id_asesi', $asesi->id_asesi)
                ->first();

            if (!$tugas) {
                return redirect()->back()->with('error', 'Tugas tidak ditemukan.');
            }

            if (!$tugas->hasFile()) {
                return redirect()->back()->with('error', 'File tidak ditemukan.');
            }

            $filePath = storage_path('app/public/' . $tugas->file_path);
            
            if (!file_exists($filePath)) {
                return redirect()->back()->with('error', 'File tidak ada di server.');
            }

            return response()->download($filePath, $tugas->file_name);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Get tasks data for JSON response (for DataTables, etc.)
     */
    public function getTasks(Request $request)
    {
        try {
            $user = Auth::user();
            $asesi = $user->asesi;
            
            if (!$asesi) {
                return response()->json(['error' => 'Data asesi tidak ditemukan.'], 403);
            }

            $tasks = IA02Tugas::byAsesi($asesi->id_asesi)
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($tugas) {
                    return [
                        'id' => $tugas->id,
                        'judul_tugas' => $tugas->judul_tugas,
                        'jenis_evidence' => $tugas->jenis_evidence_text,
                        'status' => $tugas->status_text,
                        'waktu_submit' => $tugas->waktu_submit ? $tugas->waktu_submit->format('d/m/Y H:i:s') : null,
                        'file_name' => $tugas->file_name,
                        'file_size' => $tugas->formatted_file_size,
                        'actions' => [
                            'show' => route('asesi.tugas.show', $tugas->id),
                            'download' => $tugas->hasFile() ? route('asesi.tugas.download', $tugas->id) : null,
                            'delete' => route('asesi.tugas.destroy', $tugas->id),
                        ]
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => $tasks
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
