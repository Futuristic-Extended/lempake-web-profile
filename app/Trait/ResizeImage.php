<?php

namespace App\Trait;

use Illuminate\Contracts\Filesystem\Filesystem;
use Intervention\Image\ImageManager;
use RuntimeException;

trait ResizeImage {
  protected ImageManager $imageManager;
    
  protected Filesystem $disk;

  	/**
     * Gets the file's basename and extension from the given thumbnail's filename.
     * @param string $thumbnailFilename
     * @return array<string, string>
     */
    private function getDividedFileNameAndExtension(string $thumbnailFilename): array
    {
        $originThumbnailBasename = pathinfo($thumbnailFilename, PATHINFO_FILENAME);
        $originThumbnailExt = pathinfo($thumbnailFilename, PATHINFO_EXTENSION);

        return [$originThumbnailBasename, $originThumbnailExt];
    }

    /**
     * Resizes the thumbnail.
     * @param string $originPath the original uploaded **filename**.
     * @param int $width
     * @param int $height
     * @param string $suffix used to differentiate the images' filename by its size.
     * @return string the resized image filename that concated with the given suffix.
     */
    private function resizeThumbnail(string $originPath, int $width, int $height, string $suffix): string
    {
        try {
            [$basename, $extension] = $this->getDividedFileNameAndExtension($originPath);

            $thumbnailName = "{$basename}_{$suffix}.{$extension}";
            $thumbnailPath = storage_path("app/public/thumbnails/{$thumbnailName}");

            $image = $this->imageManager->read($originPath);
            $image->resize($width, $height);
            $image->save($thumbnailPath);

            return $thumbnailName;
        } catch (RuntimeException $error) {
            throw $error;
        }
    }
}