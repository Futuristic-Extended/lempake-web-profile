<?php

namespace App\Filament\Resources\ArticleResource\Pages;

use App\Filament\Resources\ArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use App\Trait\ResizeImage;
use Filament\Actions\Action;
use Illuminate\Contracts\Support\Htmlable;
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

    public function getBreadcrumb(): string
    {
        return 'Tulis ulang';
    }

    public function getTitle(): string | Htmlable
    {
        return $this->record->title;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()->icon('heroicon-o-trash'),
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
                $smThumbnailName = '';
                $lgThumbnailName = '';

                $oldSmThumbnailName = $record->thumbnail_sm_filename;
                $oldLgThumbnailName = $record->thumbnail_lg_filename;
                
                $originThumbnailName = $data['thumbnail'];
                $originThumbnailPath = storage_path("app/public/thumbnails/$originThumbnailName");

                $destPath = storage_path("app/public/thumbnails");
                $smThumbnailName = $this->resizeImage($originThumbnailPath, 416, 279, 'sm', $destPath);
                $lgThumbnailName = $this->resizeImage($originThumbnailPath, 1248, 837, 'lg', $destPath);
    
                $data['thumbnail_sm_filename'] = $smThumbnailName;
                $data['thumbnail_lg_filename'] = $lgThumbnailName;
            }

            $record->update($data);

            if ($isUpdatingThumbnail) {
                $this->disk->delete($oldSmThumbnailName);
                $this->disk->delete($oldLgThumbnailName);
            }

            return $record;
        } catch (RuntimeException $error) {
            if ($isUpdatingThumbnail) {
                $this->disk->delete($smThumbnailName);
                $this->disk->delete($lgThumbnailName);
            }

            throw $error;
        } finally {
            if ($isUpdatingThumbnail) {
                $this->disk->delete($originThumbnailName);
            }
        }
    }

    protected function getSaveFormAction(): Action
    {
        return parent::getSaveFormAction()->icon('heroicon-o-check');
    }

    protected function getCancelFormAction(): Action
    {
        return parent::getCancelFormAction()->icon('heroicon-o-arrow-uturn-left');
    }
}
