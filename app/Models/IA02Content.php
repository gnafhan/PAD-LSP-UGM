<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class IA02Content extends Model
{
    use HasFactory;

    protected $table = 'ia02_content';

    protected $fillable = [
        'ia02_id',
        'content_type',
        'html_content',
        'delta_content',
        'text_content',
        'media_files'
    ];

    protected $casts = [
        'media_files' => 'array'
    ];

    /**
     * Relationship to IA02
     */
    public function ia02()
    {
        return $this->belongsTo(IA02::class, 'ia02_id', 'id');
    }

    /**
     * Save content with image processing
     */
    public function saveContentWithImages($htmlContent, $deltaContent = null)
    {
        // Extract images from HTML content
        $mediaFiles = $this->extractAndSaveImages($htmlContent);
        
        // Update HTML content with permanent URLs
        $processedHtml = $this->updateImageUrls($htmlContent, $mediaFiles);
        
        // Save to database
        $this->update([
            'html_content' => $processedHtml,
            'delta_content' => $deltaContent,
            'text_content' => strip_tags($processedHtml),
            'media_files' => $mediaFiles
        ]);

        return $processedHtml;
    }

    /**
     * Extract and save images from HTML content
     */
    private function extractAndSaveImages($htmlContent)
    {
        $mediaFiles = [];
        
        // Find all images in the HTML content
        preg_match_all('/<img[^>]+src="([^"]+)"/', $htmlContent, $matches);
        
        if (!empty($matches[1])) {
            foreach ($matches[1] as $imageUrl) {
                // Check if it's a temporary upload
                if (strpos($imageUrl, '/temp/') !== false) {
                    $mediaFiles[] = $this->moveToPermamentStorage($imageUrl);
                } elseif (strpos($imageUrl, '/storage/') !== false) {
                    // Already permanent, just record it
                    $mediaFiles[] = [
                        'original_url' => $imageUrl,
                        'permanent_url' => $imageUrl,
                        'file_path' => str_replace('/storage/', '', $imageUrl),
                        'type' => 'image'
                    ];
                }
            }
        }

        return $mediaFiles;
    }

    /**
     * Move temporary file to permanent storage
     */
    private function moveToPermamentStorage($tempUrl)
    {
        // Extract file path from temp URL
        $tempPath = str_replace('/storage/', '', $tempUrl);
        
        // Generate permanent path
        $fileName = basename($tempPath);
        $permanentPath = 'ia02/content/' . $this->ia02_id . '/' . time() . '_' . $fileName;
        
        // Move file
        if (Storage::disk('public')->exists($tempPath)) {
            Storage::disk('public')->move($tempPath, $permanentPath);
            
            return [
                'original_url' => $tempUrl,
                'permanent_url' => '/storage/' . $permanentPath,
                'file_path' => $permanentPath,
                'type' => 'image',
                'moved_at' => now()
            ];
        }

        return null;
    }

    /**
     * Update image URLs in HTML content
     */
    private function updateImageUrls($htmlContent, $mediaFiles)
    {
        $updatedContent = $htmlContent;
        
        foreach ($mediaFiles as $file) {
            if ($file && isset($file['original_url']) && isset($file['permanent_url'])) {
                $updatedContent = str_replace($file['original_url'], $file['permanent_url'], $updatedContent);
            }
        }

        return $updatedContent;
    }

    /**
     * Clean up temporary files
     */
    public static function cleanupTempFiles()
    {
        $tempDir = 'temp';
        $files = Storage::disk('public')->files($tempDir);
        
        foreach ($files as $file) {
            $fileTime = Storage::disk('public')->lastModified($file);
            // Delete files older than 24 hours
            if (time() - $fileTime > 86400) {
                Storage::disk('public')->delete($file);
            }
        }
    }
}
