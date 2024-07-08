<?php

namespace App\Filament\Resources\GalleryResource\Pages;

use App\Filament\Resources\GalleryResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewGallery extends ViewRecord
{
    protected static string $resource = GalleryResource::class;

    protected static string $view = 'filament.gallery.view';

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
