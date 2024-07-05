<?php

namespace App\Filament\Resources\ArticleResource\Pages;

use App\Filament\Resources\ArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use RuntimeException;

class CreateArticle extends CreateRecord
{
    protected static string $resource = ArticleResource::class;

    protected static ?string $title = 'Tulis artikel';

    protected ImageManager $imageManager;
    
    protected Filesystem $disk;

    public function __construct()
    {
        $this->imageManager = ImageManager::imagick();
        $this->disk = Storage::disk('thumbnails');
    }

    public function getBreadcrumb(): string
    {
        return 'Tulis artikel';
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['writer_id'] = auth()->id();
        return $data;
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

    protected function handleRecordCreation(array $data): Model
    {
        try {
            $originThumbnailPath = storage_path("app/public/thumbnails/{$data['thumbnail']}");

            $smSizeThumbnailName = $this->resizeThumbnail($originThumbnailPath, 416, 279, 'sm');
            $lgSizeThumbnailName = $this->resizeThumbnail($originThumbnailPath, 1248, 837, 'lg');

            $data['thumbnail_sm_filename'] = $smSizeThumbnailName;
            $data['thumbnail_lg_filename'] = $lgSizeThumbnailName;

            return static::getModel()::create($data);
        } catch (RuntimeException $error) {
            $this->cancelUploadedThumbnails(
                origin: $originThumbnailPath,
                sm: $smSizeThumbnailName,
                lg: $lgSizeThumbnailName
            );

            throw $error;
        }
    }

    protected function getCreateFormAction(): Actions\Action
    {
        return Actions\Action::make('create')
            ->label('Buat artikel')
            ->submit('create')
            ->keyBindings(['mod+s']);
    }

    protected function getCancelFormAction(): Actions\Action
    {
        return Actions\Action::make('cancel')
            ->label('Batal')
            ->alpineClickHandler('document.referrer ? window.history.back() : (window.location.href = ' . \Illuminate\Support\Js::from($this->previousUrl ?? static::getResource()::getUrl()) . ')')
            ->color('gray');
    }

    public static function canCreateAnother(): bool
    {
        return false;
    }
}