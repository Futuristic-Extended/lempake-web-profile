<?php

namespace App\Filament\Resources\ArticleResource\Pages;

use App\Filament\Resources\ArticleResource;
use Filament\Actions;
use Illuminate\Support\Js;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;

class CreateArticle extends CreateRecord
{
    protected static string $resource = ArticleResource::class;

    protected static ?string $title = 'Buat artikel';

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['writer_id'] = auth()->id();
        $data['thumbnail_sm_url'] = 'asd';
        $data['thumbnail_lg_url'] = 'asd';

        return $data;
    }

    protected function handleRecordCreation(array $data): Model
    {
        $originalThumbnailPath = storage_path('app/public/thumbnails/'.$data['thumbnail']);
        $originalThumbnailBasename = explode('.', pathinfo($data['thumbnail'], PATHINFO_BASENAME))[0];
        $originalThumbnailExt = pathinfo($data['thumbnail'], PATHINFO_EXTENSION);

        $smallSizeThumbnailName = $originalThumbnailBasename . '_sm.' . $originalThumbnailExt;
        $smallSizeThumbnailPath = storage_path('app/public/thumbnails/'.$smallSizeThumbnailName);

        // Resize original image to become the small thumbnail
        $image = ImageManager::imagick()->read($originalThumbnailPath);
        $image->resize(width: 416, height: 279);
        $image->save($smallSizeThumbnailPath);

        $data['thumbnail_sm_url'] = $smallSizeThumbnailName;

        return static::getModel()::create($data);
    }

    protected function getCreateFormAction(): Action
    {
        return Action::make('create')
            ->label('Buat artikel')
            ->submit('create')
            ->keyBindings(['mod+s']);
    }

    protected function getCancelFormAction(): Action
    {
        return Action::make('cancel')
            ->label('Batal')
            ->alpineClickHandler('document.referrer ? window.history.back() : (window.location.href = ' . Js::from($this->previousUrl ?? static::getResource()::getUrl()) . ')')
            ->color('gray');
    }

    public static function canCreateAnother(): bool
    {
        return false;
    }
}
