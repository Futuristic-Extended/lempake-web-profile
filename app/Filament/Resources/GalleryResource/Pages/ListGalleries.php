<?php

namespace App\Filament\Resources\GalleryResource\Pages;

use App\Filament\Resources\GalleryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGalleries extends ListRecords
{
    protected static string $resource = GalleryResource::class;

    protected static ?string $title = 'Daftar Unggahan';

    public function getBreadcrumb(): string
    {
        return '';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Unggah gambar')
                ->icon('heroicon-o-folder-plus'),
        ];
    }
}
