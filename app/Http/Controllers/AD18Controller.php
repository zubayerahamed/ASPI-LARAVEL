<?php

namespace App\Http\Controllers;

use App\Models\Cadoc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class AD18Controller extends ZayaanController
{

    public function create(Request $request)
    {
        $uploadedFile = $request->file('thumbnail');
        $mediaType = $uploadedFile->getMimeType();
        $fileOriginalName = $uploadedFile->getClientOriginalName();
        $fileExtention = $uploadedFile->getClientOriginalExtension();
        $fileSizeBytes = $uploadedFile->getSize();
        $fileSize = number_format($fileSizeBytes * 0.001, 2) . ' Kb';

        $supportedFileExt = [
            ".jpg",
            ".jpeg",
            ".png",
            ".gif",
            ".ico",
            ".pdf",
            ".doc",
            ".docx",
            ".ppt",
            ".pptx",
            ".pps",
            ".ppsx",
            ".odt",
            ".csv",
            ".xls",
            ".xlsx",
            ".PSD",
            ".mp3",
            ".m4a",
            ".ogg",
            ".wav",
            ".mp4",
            ".m4v",
            ".mov",
            ".wmv",
            ".avi",
            ".mpg",
            ".ogv",
            ".3gp",
            ".3g2"
        ];

        if (!in_array('.' . $fileExtention, $supportedFileExt)) {
            return response()->json(['error' => 'Unsupported file type.'], 400);
        }

        $uploadPath = 'uploads/documents/' . date('Y') . '/' . date('m') . '/' . date('d');
        $compressedUploadPath = $uploadPath . '/compressed';

        // Create directories with proper paths
        $this->createDirectories($uploadPath, $compressedUploadPath);

        $newFileName = uniqid() . '.' . $fileExtention;

        $uploadone = $uploadedFile->storeAs($uploadPath, $newFileName, 'public');
        if (!$uploadone) {
            return response()->json(['error' => 'File upload failed.'], 500);
        }

        //dd($uploadone);

        $media = new Cadoc();
        $media->file_name = $newFileName;
        $media->original_file_name = $fileOriginalName;
        $media->file_extension = $fileExtention;
        $media->media_type = $mediaType;
        $media->file_size = $fileSize;
        $media->file_path = '/' . $uploadPath . '/';

        $saved = $media->save();
        if ($saved) {
            return response()->json(['media_id' => $media->id]);
        }

        return response()->json(['error' => 'Failed to save document record.'], 500);
    }

    private function createDirectories($uploadPath, $compressedUploadPath)
    {
        $directories = [
            storage_path('app/public/' . $uploadPath),
            storage_path('app/public/' . $compressedUploadPath)
        ];

        foreach ($directories as $directory) {
            if (!is_dir($directory)) {
                mkdir($directory, 0755, true);
            }
        }
    }

    public function destroy(Request $request)
    {
        $cadoc = Cadoc::find($request->id);
        if (!$cadoc) {
            return response()->json(['error' => 'Document not found.'], 404);
        }

        // Store file paths and info for response
        $fileInfo = [
            'original_file' => 'storage' . $cadoc->file_path . $cadoc->file_name,
            'compressed_file' => 'storage' . $cadoc->file_path_compressed . $cadoc->file_name,
            'file_name' => $cadoc->file_name,
            'original_name' => $cadoc->original_file_name
        ];

        if ($cadoc->delete()) {
            // Delete files from storage
            $deletionResults = $this->deletePhysicalFiles($fileInfo);

            $successMessage = 'File removed successfully';
            $logContext = [
                'file_info' => $fileInfo,
                'deletion_results' => $deletionResults
            ];

            Log::info('Media file deleted successfully', $logContext);

            return response()->json(['message' => $successMessage]);
        }

        return response()->json(['error' => 'Failed to delete document record.'], 500);
    }

    private static function deletePhysicalFiles($fileInfo)
    {
        $results = [
            'original_file' => ['exists' => false, 'deleted' => false, 'error' => null],
            'compressed_file' => ['exists' => false, 'deleted' => false, 'error' => null]
        ];

        // Delete original file
        try {
            if (file_exists($fileInfo['original_file'])) {
                $results['original_file']['exists'] = true;
                if (unlink($fileInfo['original_file'])) {
                    $results['original_file']['deleted'] = true;

                    // Clean up directory
                    self::cleanupEmptyDirectories(dirname($fileInfo['original_file']));
                } else {
                    $results['original_file']['error'] = 'Failed to unlink file';
                }
            }
        } catch (\Exception $e) {
            $results['original_file']['error'] = $e->getMessage();
            Log::error('Failed to delete original file: ' . $e->getMessage(), $fileInfo);
        }

        // Delete compressed file
        try {
            if (file_exists($fileInfo['compressed_file'])) {
                $results['compressed_file']['exists'] = true;
                if (unlink($fileInfo['compressed_file'])) {
                    $results['compressed_file']['deleted'] = true;

                    // Clean up directory
                    self::cleanupEmptyDirectories(dirname($fileInfo['compressed_file']));
                } else {
                    $results['compressed_file']['error'] = 'Failed to unlink file';
                }
            }
        } catch (\Exception $e) {
            $results['compressed_file']['error'] = $e->getMessage();
            Log::error('Failed to delete compressed file: ' . $e->getMessage(), $fileInfo);
        }

        return $results;
    }

    /**
     * Clean up empty directories recursively
     */
    private static function cleanupEmptyDirectories($directoryPath)
    {
        try {
            // Only proceed if it's a storage directory to avoid accidental deletions
            if (strpos($directoryPath, 'storage/uploads/media') === false) {
                return;
            }

            if (is_dir($directoryPath) && self::isDirectoryEmpty($directoryPath)) {
                rmdir($directoryPath);

                // Recursively check and remove parent directories if empty
                $parentDir = dirname($directoryPath);
                if (is_dir($parentDir) && self::isDirectoryEmpty($parentDir)) {
                    rmdir($parentDir);

                    // Go one level up if needed
                    $grandParentDir = dirname($parentDir);
                    if (is_dir($grandParentDir) && self::isDirectoryEmpty($grandParentDir)) {
                        rmdir($grandParentDir);
                    }
                }
            }
        } catch (\Exception $e) {
            // Log but don't throw - directory cleanup failure shouldn't break the main process
            Log::warning('Directory cleanup failed: ' . $e->getMessage(), ['directory' => $directoryPath]);
        }
    }

    private static function isDirectoryEmpty($dir)
    {
        if (!is_readable($dir)) {
            return false;
        }

        $handle = opendir($dir);
        if ($handle === false) {
            return false;
        }

        while (false !== ($entry = readdir($handle))) {
            if ($entry != "." && $entry != "..") {
                closedir($handle);
                return false;
            }
        }

        closedir($handle);
        return true;
    }
}
