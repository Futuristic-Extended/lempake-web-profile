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

    protected static ?string $title = 'Unggah gambar';

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
        return parent::getCreateFormAction()
            ->label('Unggah')
            ->icon('heroicon-o-arrow-up-tray');
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
