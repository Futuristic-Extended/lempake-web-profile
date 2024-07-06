<?php

namespace App\Filament\Resources\ArticleResource\Pages;

use App\Filament\Resources\ArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use RuntimeException;

class EditArticle extends EditRecord
{
    protected static string $resource = ArticleResource::class;

    protected ImageManager $imageManager;
    
    protected Filesystem $disk;

    public function __construct()
    {
        $this->imageManager = ImageManager::imagick();
        $this->disk = Storage::disk('thumbnails');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        $resource = static::getResource();
        return $resource::getUrl('view', ['record' => $this->getRecord()]);
    }

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

    /**
     * Cancels (deletes) the uploaded or resized thumbnails when error occured in the record transaction.
     * @param string $origin the raw (uploaded by user) thumbnail **filename**.
     * @param string $sm the small sized thumbnail **filename**.
     * @param string $lg the large sized thumbnail **filename**.
     * @return void
     */
    private function cancelUploadedThumbnails(string $origin, string $sm, string $lg): void
    {
        $this->disk->delete($origin);
        $this->disk->delete($sm);
        $this->disk->delete($lg);
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $smSizeThumbnailName = '';
        $lgSizeThumbnailName = '';
        
        try {
            $originThumbnailPath = storage_path("app/public/thumbnails/{$data['thumbnail']}");

            $smSizeThumbnailName = $this->resizeThumbnail($originThumbnailPath, 416, 279, 'sm');
            $lgSizeThumbnailName = $this->resizeThumbnail($originThumbnailPath, 1248, 837, 'lg');

            $data['thumbnail_sm_filename'] = $smSizeThumbnailName;
            $data['thumbnail_lg_filename'] = $lgSizeThumbnailName;

            $record->update($data);

            return $record;
        } catch (RuntimeException $error) {
            $this->cancelUploadedThumbnails(
                origin: $originThumbnailPath,
                sm: $smSizeThumbnailName,
                lg: $lgSizeThumbnailName
            );

            throw $error;
        }
    }
}
