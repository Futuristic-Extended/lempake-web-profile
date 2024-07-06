<?php

namespace App\Filament\Resources\ArticleResource\Pages;

use App\Filament\Resources\ArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use App\Trait\ResizeImage;
use RuntimeException;

class EditArticle extends EditRecord
{
    use ResizeImage;

    protected static string $resource = ArticleResource::class;

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

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        try {
            $isUpdatingThumbnail = isset($data['thumbnail']) && $data['thumbnail'] != null;

            if ($isUpdatingThumbnail) {
                $smSizeThumbnailName = '';
                $lgSizeThumbnailName = '';

                $oldSmSizeThumbnailName = $record->thumbnail_sm_filename;
                $oldLgSizeThumbnailName = $record->thumbnail_lg_filename;
    
                $originThumbnailPath = storage_path("app/public/thumbnails/{$data['thumbnail']}");
                $smSizeThumbnailName = $this->resizeThumbnail($originThumbnailPath, 416, 279, 'sm');
                $lgSizeThumbnailName = $this->resizeThumbnail($originThumbnailPath, 1248, 837, 'lg');
    
                $data['thumbnail_sm_filename'] = $smSizeThumbnailName;
                $data['thumbnail_lg_filename'] = $lgSizeThumbnailName;
            }

            $record->update($data);

            if ($isUpdatingThumbnail) {
                $this->disk->delete($data['thumbnail']);
                $this->disk->delete($oldSmSizeThumbnailName);
                $this->disk->delete($oldLgSizeThumbnailName);
            }

            return $record;
        } catch (RuntimeException $error) {
            if ($isUpdatingThumbnail) {
                $this->cancelUploadedThumbnails(
                    origin: $originThumbnailPath,
                    sm: $smSizeThumbnailName,
                    lg: $lgSizeThumbnailName
                );
            }

            throw $error;
        }
    }
}
