<?php

namespace App\Filament\Resources\ArticleResource\Pages;

use App\Filament\Resources\ArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use RuntimeException;

class CreateArticle extends CreateRecord
{
    protected static string $resource = ArticleResource::class;
    protected static ?string $title = 'Buat artikel';

    protected ImageManager $imageManager;

    public function __construct()
    {
        $this->imageManager = ImageManager::imagick();
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['writer_id'] = auth()->id();
        return $data;
    }

    private function getDividedFileNameAndExtension(string $thumbnailFilename): array
    {
        $originalThumbnailBasename = pathinfo($thumbnailFilename, PATHINFO_FILENAME);
        $originalThumbnailExt = pathinfo($thumbnailFilename, PATHINFO_EXTENSION);

        return [$originalThumbnailBasename, $originalThumbnailExt];
    }

    private function resizeThumbnail(string $originalPath, int $width, int $height, string $suffix): string
    {
        try {
            [$basename, $extension] = $this->getDividedFileNameAndExtension($originalPath);

            $thumbnailName = "{$basename}_{$suffix}.{$extension}";
            $thumbnailPath = storage_path("app/public/thumbnails/{$thumbnailName}");

            $image = $this->imageManager->read($originalPath);
            $image->resize($width, $height);
            $image->save($thumbnailPath);

            return $thumbnailName;
        } catch (RuntimeException $error) {
            throw $error;
        }
    }

    protected function handleRecordCreation(array $data): Model
    {
        try {
            $originalThumbnailPath = storage_path("app/public/thumbnails/{$data['thumbnail']}");

            $smSizeThumbnailName = $this->resizeThumbnail($originalThumbnailPath, 416, 279, 'sm');
            $lgSizeThumbnailName = $this->resizeThumbnail($originalThumbnailPath, 1248, 837, 'lg');

            $data['thumbnail_sm_filename'] = $smSizeThumbnailName;
            $data['thumbnail_lg_filename'] = $lgSizeThumbnailName;

            return static::getModel()::create($data);
        } catch (RuntimeException $error) {
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