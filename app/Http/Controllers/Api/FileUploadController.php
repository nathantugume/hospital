<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * File Upload Controller
 * 
 * Handles secure file uploads for:
 *   - Patient photos (jpg, png)
 *   - Lab report attachments (pdf, jpg, dicom)
 *   - Radiology images (dicom, jpg, png)
 *   - Insurance documents (pdf, jpg)
 *   - General documents (pdf, doc, docx)
 *
 * Security:
 *   - MIME type whitelist (no executable files)
 *   - Max file size: 10MB (configurable)
 *   - File extension validation
 *   - Stored in private disk (not publicly accessible)
 *   - Signed URLs for temporary access
 */
class FileUploadController extends Controller
{
    const MAX_FILE_SIZE = 10485760; // 10MB
    const UPLOAD_DISK = 'local'; // private disk — files not publicly accessible

    const ALLOWED_MIMES = [
        'image/jpeg', 'image/png', 'image/gif', 'image/webp',
        'application/pdf',
        'application/dicom',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'application/vnd.ms-excel',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'text/plain',
        'text/csv',
    ];

    const ALLOWED_EXTENSIONS = [
        'jpg', 'jpeg', 'png', 'gif', 'webp',
        'pdf',
        'dcm', 'dicom',
        'doc', 'docx',
        'xls', 'xlsx',
        'txt', 'csv',
    ];

    const UPLOAD_CATEGORIES = [
        'patient_photo' => ['image/jpeg', 'image/png', 'image/webp'],
        'lab_report' => ['application/pdf', 'image/jpeg', 'image/png', 'application/dicom'],
        'radiology' => ['application/dicom', 'image/jpeg', 'image/png'],
        'insurance_doc' => ['application/pdf', 'image/jpeg', 'image/png'],
        'document' => ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'text/plain'],
        'spreadsheet' => ['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'text/csv'],
    ];

    /**
     * POST /api/v1/uploads
     * Upload a single file.
     *
     * Request: multipart/form-data
     *   - file: required|file|max:10240
     *   - category: required|in:patient_photo,lab_report,radiology,insurance_doc,document,spreadsheet
     *   - patient_id: nullable|exists:patients,id
     *   - description: nullable|string|max:500
     *
     * Response: { success, data: { file_id, path, url, size, mime } }
     */
    public function upload(Request $request): JsonResponse
    {
        $request->validate([
            'file' => 'required|file|max:10240',
            'category' => 'required|in:' . implode(',', array_keys(self::UPLOAD_CATEGORIES)),
            'patient_id' => 'nullable|exists:patients,id',
            'description' => 'nullable|string|max:500',
        ]);

        $file = $request->file('file');
        $category = $request->input('category');

        // Validate MIME type
        $mime = $file->getMimeType();
        $allowedMimes = self::UPLOAD_CATEGORIES[$category];
        if (!in_array($mime, $allowedMimes)) {
            return response()->json([
                'success' => false,
                'message' => "File type '{$mime}' is not allowed for category '{$category}'.",
                'allowed_types' => $allowedMimes,
            ], 422);
        }

        // Validate extension
        $extension = strtolower($file->getClientOriginalExtension());
        if (!in_array($extension, self::ALLOWED_EXTENSIONS)) {
            return response()->json([
                'success' => false,
                'message' => "File extension '.{$extension}' is not allowed.",
            ], 422);
        }

        // Validate file size
        if ($file->getSize() > self::MAX_FILE_SIZE) {
            return response()->json([
                'success' => false,
                'message' => 'File size exceeds the 10MB limit.',
            ], 422);
        }

        // Generate secure filename
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeName = Str::slug($originalName) . '_' . Str::random(8) . '.' . $extension;

        // Store in private disk organized by category and date
        $datePath = now()->format('Y/m/d');
        $path = "uploads/{$category}/{$datePath}/{$safeName}";

        Storage::disk(self::UPLOAD_DISK)->putFileAs(
            "uploads/{$category}/{$datePath}",
            $file,
            $safeName
        );

        // Log the upload
        activity()
            ->causedBy($request->user())
            ->withProperties([
                'category' => $category,
                'filename' => $safeName,
                'size' => $file->getSize(),
                'mime' => $mime,
                'patient_id' => $request->input('patient_id'),
            ])
            ->log('File uploaded: ' . $category);

        return response()->json([
            'success' => true,
            'message' => 'File uploaded successfully.',
            'data' => [
                'file_id' => Str::uuid()->toString(),
                'path' => $path,
                'filename' => $safeName,
                'original_name' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'size_human' => $this->formatBytes($file->getSize()),
                'mime' => $mime,
                'extension' => $extension,
                'category' => $category,
                'uploaded_at' => now()->toIso8601String(),
            ],
        ], 201);
    }

    /**
     * GET /api/v1/uploads/{path}
     * Download/view a file via signed URL.
     */
    public function download(Request $request, string $path): JsonResponse|\Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        // Decode the path
        $fullPath = "uploads/{$path}";

        if (!Storage::disk(self::UPLOAD_DISK)->exists($fullPath)) {
            return response()->json([
                'success' => false,
                'message' => 'File not found.',
            ], 404);
        }

        // Log the download
        activity()
            ->causedBy($request->user())
            ->withProperties(['path' => $fullPath])
            ->log('File downloaded: ' . $path);

        $file = Storage::disk(self::UPLOAD_DISK)->path($fullPath);
        $mime = Storage::disk(self::UPLOAD_DISK)->mimeType($fullPath);

        return response()->download($file, basename($fullPath), [
            'Content-Type' => $mime,
            'Cache-Control' => 'private, max-age=3600',
        ]);
    }

    /**
     * DELETE /api/v1/uploads/{path}
     * Delete a file (admin only).
     */
    public function destroy(Request $request, string $path): JsonResponse
    {
        $fullPath = "uploads/{$path}";

        if (!Storage::disk(self::UPLOAD_DISK)->exists($fullPath)) {
            return response()->json([
                'success' => false,
                'message' => 'File not found.',
            ], 404);
        }

        // Only admins can delete files
        if (!$request->user()->hasRole(['admin', 'super_admin'])) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to delete files.',
            ], 403);
        }

        Storage::disk(self::UPLOAD_DISK)->delete($fullPath);

        activity()
            ->causedBy($request->user())
            ->withProperties(['path' => $fullPath])
            ->log('File deleted: ' . $path);

        return response()->json([
            'success' => true,
            'message' => 'File deleted successfully.',
        ]);
    }

    /**
     * POST /api/v1/uploads/multiple
     * Upload multiple files at once (max 10 files).
     */
    public function uploadMultiple(Request $request): JsonResponse
    {
        $request->validate([
            'files.*' => 'required|file|max:10240',
            'category' => 'required|in:' . implode(',', array_keys(self::UPLOAD_CATEGORIES)),
            'patient_id' => 'nullable|exists:patients,id',
        ]);

        $files = $request->file('files');
        if (count($files) > 10) {
            return response()->json([
                'success' => false,
                'message' => 'Maximum 10 files per upload.',
            ], 422);
        }

        $results = [];
        $errors = [];

        foreach ($files as $index => $file) {
            try {
                $category = $request->input('category');
                $mime = $file->getMimeType();
                $allowedMimes = self::UPLOAD_CATEGORIES[$category];

                if (!in_array($mime, $allowedMimes)) {
                    $errors[] = ['index' => $index, 'filename' => $file->getClientOriginalName(), 'error' => "MIME type '{$mime}' not allowed for '{$category}'"];
                    continue;
                }

                $extension = strtolower($file->getClientOriginalExtension());
                if (!in_array($extension, self::ALLOWED_EXTENSIONS)) {
                    $errors[] = ['index' => $index, 'filename' => $file->getClientOriginalName(), 'error' => "Extension '.{$extension}' not allowed"];
                    continue;
                }

                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $safeName = Str::slug($originalName) . '_' . Str::random(8) . '.' . $extension;
                $datePath = now()->format('Y/m/d');
                $path = "uploads/{$category}/{$datePath}/{$safeName}";

                Storage::disk(self::UPLOAD_DISK)->putFileAs("uploads/{$category}/{$datePath}", $file, $safeName);

                $results[] = [
                    'file_id' => Str::uuid()->toString(),
                    'path' => $path,
                    'filename' => $safeName,
                    'original_name' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                    'mime' => $mime,
                ];
            } catch (\Exception $e) {
                $errors[] = ['index' => $index, 'filename' => $file->getClientOriginalName(), 'error' => $e->getMessage()];
            }
        }

        return response()->json([
            'success' => count($errors) === 0,
            'message' => count($results) . ' file(s) uploaded, ' . count($errors) . ' error(s).',
            'data' => $results,
            'errors' => $errors,
        ], 201);
    }

    /**
     * GET /api/v1/uploads/categories
     * Returns the list of allowed upload categories and their MIME types.
     */
    public function categories(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => self::UPLOAD_CATEGORIES,
            'max_file_size' => self::MAX_FILE_SIZE,
            'max_file_size_human' => $this->formatBytes(self::MAX_FILE_SIZE),
        ]);
    }

    private function formatBytes(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;
        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }
        return round($bytes, 1) . ' ' . $units[$i];
    }
}
