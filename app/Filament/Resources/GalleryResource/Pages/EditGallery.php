<?php

namespace App\Filament\Resources\GalleryResource\Pages;

use App\Filament\Resources\GalleryResource;
use App\Trait\ResizeImage;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use RuntimeException;

class EditGallery extends EditRecord
{
    use ResizeImage;

    protected static string $resource = GalleryResource::class;

    protected static ?string $breadcrumb = 'Edit';

    protected static ?string $title = 'Edit galeri';

    public function __construct()
    {
        $this->imageManager = ImageManager::imagick();
        $this->disk = Storage::disk('galleries');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordCreation(array $data): Model
    {
        try {
            return static::getModel()::create($data);
        } catch (RuntimeException $error) {
            throw $error;
        }
    }
}
