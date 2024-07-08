<?php

namespace App\Filament\Resources\GalleryResource\Pages;

use App\Filament\Resources\GalleryResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\Support\Htmlable;

class ViewGallery extends ViewRecord
{
    protected static string $resource = GalleryResource::class;

    protected static string $view = 'filament.gallery.view';
    
    public function getBreadcrumb(): string
    {
        return 'Gambar';
    }

    public function getTitle(): string | Htmlable
    {
        return $this->record->title;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->label('Edit unggahan ini')
                ->icon('heroicon-o-pencil-square'),
        ];
    }
}
