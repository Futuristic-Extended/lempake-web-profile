<?php

namespace App\Filament\Resources\GalleryResource\Pages;

use App\Filament\Resources\GalleryResource;
use App\Trait\ResizeImage;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use RuntimeException;

class CreateGallery extends CreateRecord
{
    use ResizeImage;

    protected static string $resource = GalleryResource::class;

    protected static ?string $breadcrumb = 'Unggah';

    protected static ?string $title = 'Unggah galeri';

    public function __construct()
    {
        $this->imageManager = ImageManager::imagick();
        $this->disk = Storage::disk('galleries');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['uploader_id'] = auth()->id();
        return $data;
    }

    protected function handleRecordCreation(array $data): Model
    {
        try {
            $gallery = static::getModel()::create($data);

            foreach ($data['images'] as $image) {
                $image = storage_path("app/public/galleries/$image");
                $destPath = storage_path("app/public/galleries");

                $smImageName = $this->resizeImage($image, 416, 279, 'sm', $destPath);
                $lgImageName = $this->resizeImage($image, 1248, 837, 'lg', $destPath);

                $gallery->images()->create([
                    'image_sm_filename' => $smImageName,
                    'image_lg_filename' => $lgImageName
                ]);
            }

            return $gallery;
        } catch (RuntimeException $error) {
            isset($smImageName) && $this->disk->delete($smImageName);
            isset($lgImageName) && $this->disk->delete($lgImageName);

            throw $error;
        } finally {
            foreach ($data['images'] as $image) $this->disk->delete($image);
        }
    }

    protected function getCreateFormAction(): Actions\Action
    {
        return Actions\Action::make('create')
            ->label('Unggah')
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
