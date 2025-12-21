<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Fix tanda_tangan_asesor file_tanda_tangan to use actual file in storage
     */
    public function up(): void
    {
        // Get actual signature files from storage
        $signatureFiles = Storage::disk('public')->files('tanda_tangan');
        $signatureFiles = array_filter($signatureFiles, function($file) {
            return preg_match('/\.(jpg|jpeg|png|gif)$/i', $file);
        });
        $signatureFiles = array_values($signatureFiles);
        
        if (count($signatureFiles) > 0) {
            // Use the first actual signature file found
            $actualFilename = basename($signatureFiles[0]);
            
            // Update all records that have non-existent files
            DB::table('tanda_tangan_asesor')
                ->where('file_tanda_tangan', 'like', 'asesor_signature_%')
                ->update(['file_tanda_tangan' => $actualFilename]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Cannot reliably reverse this migration
    }
};
