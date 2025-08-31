<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Skema;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    //Method untuk menampilkan data di home admin
    public function index(Request $request)
    {
        $query = Skema::query();
        
        // Add search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nomor_skema', 'LIKE', "%{$search}%")
                  ->orWhere('nama_skema', 'LIKE', "%{$search}%")
                  ->orWhere('persyaratan_skema', 'LIKE', "%{$search}%");
            });
        }
        
        $skemaData = $query->get();
        
        // Process each skema to add parsed_persyaratan as a dynamic property
        foreach ($skemaData as $skema) {
            $skema->setAttribute('parsed_persyaratan', 
                array_filter(array_map('trim', explode(',', $skema->persyaratan_skema ?? '')))
            );
        }
        
        return view('home.home-visitor.skema', [
            'skemaData' => $skemaData,
            'searchQuery' => $request->search ?? ''
        ]);
    }

    /**
     * Handle temporary image upload for Quill.js
     */
    public function uploadImage(Request $request)
    {
        try {
            $request->validate([
                'upload' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // max 2MB
            ]);

            if ($request->hasFile('upload')) {
                $file = $request->file('upload');
                $filename = 'temp_' . time() . '_' . $file->getClientOriginalName();
                
                // Store in temporary directory
                $path = $file->storeAs('uploads/temp', $filename, 'public');
                
                // Return the temporary URL
                $url = asset('storage/' . $path);
                
                // Debug log
                Log::info('Temporary image uploaded:', [
                    'filename' => $filename,
                    'path' => $path,
                    'url' => $url
                ]);
                
                return response()->json([
                    'uploaded' => true,
                    'url' => $url,
                    'fileName' => $filename,
                    'temporary' => true
                ]);
            }

            return response()->json([
                'uploaded' => false,
                'error' => [
                    'message' => 'No file uploaded'
                ]
            ], 400);

        } catch (\Exception $e) {
            return response()->json([
                'uploaded' => false,
                'error' => [
                    'message' => 'Upload failed: ' . $e->getMessage()
                ]
            ], 500);
        }
    }

    /**
     * Save final content with images moved to permanent location
     */
    public function saveInstruksiKerja(Request $request)
    {
        try {
            $content = $request->input('content');
            
            // Find all temporary images in content
            preg_match_all('/storage\/uploads\/temp\/(temp_\d+_[^"]+)/', $content, $matches);
            
            if (!empty($matches[1])) {
                foreach ($matches[1] as $tempFilename) {
                    $tempPath = storage_path('app/public/uploads/temp/' . $tempFilename);
                    
                    if (file_exists($tempPath)) {
                        // Generate permanent filename
                        $permanentFilename = str_replace('temp_', '', $tempFilename);
                        $permanentPath = 'uploads/images/' . $permanentFilename;
                        
                        // Move file to permanent location
                        $moved = rename($tempPath, storage_path('app/public/' . $permanentPath));
                        
                        if ($moved) {
                            // Update content URLs
                            $oldUrl = 'storage/uploads/temp/' . $tempFilename;
                            $newUrl = 'storage/' . $permanentPath;
                            $content = str_replace($oldUrl, $newUrl, $content);
                            
                            Log::info('Image moved to permanent location:', [
                                'from' => $tempPath,
                                'to' => $permanentPath
                            ]);
                        }
                    }
                }
            }
            
            // Here you would save the content to database
            // Example: YourModel::create(['content' => $content]);
            
            return response()->json([
                'success' => true,
                'message' => 'Instruksi kerja berhasil disimpan',
                'content' => $content
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan: ' . $e->getMessage()
            ], 500);
        }
    }
}
