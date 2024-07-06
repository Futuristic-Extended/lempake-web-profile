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
        $smSizeThumbnailName = '';
        $lgSizeThumbnailName = '';
        
        try {
            $originThumbnailPath = storage_path("app/public/thumbnails/{$data['thumbnail']}");

            $smSizeThumbnailName = $this->resizeThumbnail($originThumbnailPath, 416, 279, 'sm');
            $lgSizeThumbnailName = $this->resizeThumbnail($originThumbnailPath, 1248, 837, 'lg');

            $data['thumbnail_sm_filename'] = $smSizeThumbnailName;
            $data['thumbnail_lg_filename'] = $lgSizeThumbnailName;

            $this->disk->delete($data['thumbnail']);

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