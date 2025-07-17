<?php

namespace App\Http\Controllers;

use App\Models\IA02Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class IA02ContentController extends Controller
{
    /**
     * Save Quill.js content (text only)
     */
    public function saveContent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ia02_id' => 'required|string|exists:ia02,id',
            'content_type' => 'required|string',
            'html_content' => 'required|string',
            'delta_content' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 400);
        }

        try {
            // Find or create content record
            $content = IA02Content::firstOrCreate(
                [
                    'ia02_id' => $request->ia02_id,
                    'content_type' => $request->content_type
                ],
                [
                    'html_content' => '',
                    'delta_content' => null,
                    'text_content' => ''
                ]
            );

            // Save content
            $content->html_content = $request->html_content;
            $content->delta_content = $request->delta_content;
            $content->save();

            return response()->json([
                'success' => true,
                'message' => 'Content saved successfully',
                'content' => $content->html_content
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save content: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Load content for Quill.js editor
     */
    public function loadContent(Request $request, $ia02Id, $contentType = 'instruksi_kerja')
    {
        try {
            $content = IA02Content::where('ia02_id', $ia02Id)
                                 ->where('content_type', $contentType)
                                 ->first();

            if (!$content) {
                return response()->json([
                    'success' => true,
                    'message' => 'No content found',
                    'content' => '',
                    'delta' => null
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Content loaded successfully',
                'content' => $content->html_content,
                'delta' => $content->delta_content,
                'text' => $content->text_content
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load content: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete content
     */
    public function deleteContent($ia02Id, $contentType = 'instruksi_kerja')
    {
        try {
            $content = IA02Content::where('ia02_id', $ia02Id)
                                 ->where('content_type', $contentType)
                                 ->first();

            if ($content) {
                $content->delete();
            }

            return response()->json([
                'success' => true,
                'message' => 'Content deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete content: ' . $e->getMessage()
            ], 500);
        }
    }
}
