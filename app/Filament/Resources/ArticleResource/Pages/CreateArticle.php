<?php

namespace App\Filament\Resources\ArticleResource\Pages;

use App\Filament\Resources\ArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use App\Trait\ResizeImage;
use RuntimeException;

class CreateArticle extends CreateRecord
{
    use ResizeImage;

    protected static string $resource = ArticleResource::class;

    protected static ?string $title = 'Tulis artikel';

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

    protected function handleRecordCreation(array $data): Model
    {
        try {
            $smThumbnailName = '';
            $lgThumbnailName = '';

            $originThumbnailName = $data['thumbnail'];
            $originThumbnailPath = storage_path("app/public/thumbnails/$originThumbnailName");

            $destPath = storage_path("app/public/thumbnails");
            $smThumbnailName = $this->resizeImage($originThumbnailPath, 416, 279, 'sm', $destPath);
            $lgThumbnailName = $this->resizeImage($originThumbnailPath, 1248, 837, 'lg', $destPath);

            $data['thumbnail_sm_filename'] = $smThumbnailName;
            $data['thumbnail_lg_filename'] = $lgThumbnailName;

            return static::getModel()::create($data);
        } catch (RuntimeException $error) {
            $this->disk->delete($smThumbnailName);
            $this->disk->delete($lgThumbnailName);

            throw $error;
        } finally {
            $this->disk->delete($originThumbnailName);
        }
    }

    protected function getCreateFormAction(): Actions\Action
    {
        return parent::getCreateFormAction()
            ->label('Tulis artikel')
            ->icon('heroicon-o-pencil-square');
    }

    protected function getCancelFormAction(): Actions\Action
    {
        return parent::getCancelFormAction()->icon('heroicon-o-arrow-uturn-left');
    }
    
    protected function getRedirectUrl(): string
    {
        $resource = static::getResource();
        return $resource::getUrl('view', ['record' => $this->getRecord()]);
    }

    public static function canCreateAnother(): bool
    {
        return false;
    }
}