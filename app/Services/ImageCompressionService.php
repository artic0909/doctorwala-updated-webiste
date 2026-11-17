<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageCompressionService
{
    /**
     * Compress and store an uploaded image or document.
     *
     * @param UploadedFile|mixed $file The uploaded file instance
     * @param string $directory Target storage directory (e.g. 'medical_histories/1', 'partner-opd-profile')
     * @param string $disk Storage disk (default 'public')
     * @param int $maxWidth Max width in pixels (default 1600)
     * @param int $maxHeight Max height in pixels (default 1600)
     * @param int $quality Compression quality 1-100 (default 75)
     * @return string Stored file path relative to disk root (same format as $file->store())
     */
    public static function compressAndStore(
        $file,
        string $directory,
        string $disk = 'public',
        int $maxWidth = 1600,
        int $maxHeight = 1600,
        int $quality = 75
    ): string {
        if (!($file instanceof UploadedFile)) {
            return '';
        }

        $extension = strtolower($file->getClientOriginalExtension());
        $mime = $file->getMimeType() ?? '';

        // If it is not an image (e.g., PDF or document), store directly without alteration
        if (!in_array($extension, ['jpg', 'jpeg', 'png', 'webp', 'bmp']) || str_starts_with($mime, 'application/pdf')) {
            return $file->store($directory, $disk);
        }

        try {
            $realPath = $file->getRealPath();
            if (!$realPath || !file_exists($realPath)) {
                return $file->store($directory, $disk);
            }

            // Create GD image resource based on file type
            $sourceImage = null;
            switch ($extension) {
                case 'jpeg':
                case 'jpg':
                    $sourceImage = @imagecreatefromjpeg($realPath);
                    break;
                case 'png':
                    $sourceImage = @imagecreatefrompng($realPath);
                    break;
                case 'webp':
                    $sourceImage = @imagecreatefromwebp($realPath);
                    break;
                case 'bmp':
                    $sourceImage = @imagecreatefrombmp($realPath);
                    break;
            }

            if (!$sourceImage) {
                return $file->store($directory, $disk);
            }

            // Handle phone camera EXIF orientation
            if (in_array($extension, ['jpg', 'jpeg']) && function_exists('exif_read_data')) {
                $exif = @exif_read_data($realPath);
                if (!empty($exif['Orientation'])) {
                    switch ($exif['Orientation']) {
                        case 3:
                            $sourceImage = imagerotate($sourceImage, 180, 0);
                            break;
                        case 6:
                            $sourceImage = imagerotate($sourceImage, -90, 0);
                            break;
                        case 8:
                            $sourceImage = imagerotate($sourceImage, 90, 0);
                            break;
                    }
                }
            }

            $origWidth = imagesx($sourceImage);
            $origHeight = imagesy($sourceImage);

            // Calculate scaled dimensions maintaining aspect ratio
            $targetWidth = $origWidth;
            $targetHeight = $origHeight;

            if ($origWidth > $maxWidth || $origHeight > $maxHeight) {
                $ratio = min($maxWidth / $origWidth, $maxHeight / $origHeight);
                $targetWidth = (int) max(1, round($origWidth * $ratio));
                $targetHeight = (int) max(1, round($origHeight * $ratio));
            }

            // Create true color destination canvas
            $targetImage = imagecreatetruecolor($targetWidth, $targetHeight);

            // Preserve transparency for PNG and WebP
            if (in_array($extension, ['png', 'webp'])) {
                imagealphablending($targetImage, false);
                imagesavealpha($targetImage, true);
                $transparent = imagecolorallocatealpha($targetImage, 255, 255, 255, 127);
                imagefilledrectangle($targetImage, 0, 0, $targetWidth, $targetHeight, $transparent);
            }

            // High-quality bicubic resampling
            imagecopyresampled(
                $targetImage,
                $sourceImage,
                0, 0, 0, 0,
                $targetWidth,
                $targetHeight,
                $origWidth,
                $origHeight
            );

            // Generate filename and relative destination path
            $normalizedExt = ($extension === 'jpeg') ? 'jpg' : $extension;
            $filename = Str::random(40) . '.' . $normalizedExt;
            $cleanDir = trim($directory, '/');
            $relativePath = $cleanDir . '/' . $filename;

            // Ensure destination folder exists
            Storage::disk($disk)->makeDirectory($cleanDir);
            $fullDestinationPath = Storage::disk($disk)->path($relativePath);

            // Compress and save
            $saved = false;
            switch ($normalizedExt) {
                case 'jpg':
                    $saved = imagejpeg($targetImage, $fullDestinationPath, $quality);
                    break;
                case 'png':
                    $saved = imagepng($targetImage, $fullDestinationPath, 7);
                    break;
                case 'webp':
                    $saved = imagewebp($targetImage, $fullDestinationPath, $quality);
                    break;
                default:
                    $saved = imagejpeg($targetImage, $fullDestinationPath, $quality);
                    break;
            }

            imagedestroy($sourceImage);
            imagedestroy($targetImage);

            if ($saved && file_exists($fullDestinationPath)) {
                return $relativePath;
            }

            return $file->store($directory, $disk);

        } catch (\Throwable $e) {
            Log::warning("ImageCompressionService fallback: " . $e->getMessage());
            return $file->store($directory, $disk);
        }
    }
}
