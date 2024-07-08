<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GalleryResource\Pages;
use App\Filament\Resources\GalleryResource\RelationManagers;
use App\Models\Gallery;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Pages\Page;
use Filament\Tables\Columns\TextColumn;

class GalleryResource extends Resource
{
    protected static ?string $model = Gallery::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $modelLabel = 'Galeri';

    protected static ?string $pluralModelLabel = 'Galeri';

    protected static ?string $breadcrumb = 'Galeri';

    public static function form(Form $form): Form
    {
        $schema = [
            Forms\Components\TextInput::make('title')
                ->columnSpanFull()
                ->label('Judul')
                ->maxLength(50)
                ->required(),
            Textarea::make('description')
                ->columnSpanFull()
                ->label('Keterangan (opsional)')
                ->maxLength(200)
        ];

        if ($form->getOperation() === 'create') {
            $schema[] = FileUpload::make('images')
                ->columnSpanFull()
                ->multiple()
                ->disk('galleries')
                ->label('Gambar (bisa lebih dari satu)')
                ->placeholder('Masukkan gambar-gambar di sini, gambar hanya boleh bertipe jpg, jpeg, atau png.')
                ->acceptedFileTypes(['image/jpg', 'image/jpeg', 'image/png'])
                ->required();
        }

        return $form->schema($schema);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('#')
                    ->rowIndex(),
                TextColumn::make('title')
                    ->label('Judul'),
                TextColumn::make('description')
                    ->label('Keterangan'),
                TextColumn::make('images_count')
                    ->label('Jumlah gambar')
                    ->counts('images'),
                TextColumn::make('uploader.name')
                    ->label('Diunggah oleh')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Lihat gambar')
                    ->icon('heroicon-o-photo'),
                Tables\Actions\EditAction::make()
                    ->icon('heroicon-o-pencil-square')
                    ->label('Edit unggahan'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGalleries::route('/'),
            'create' => Pages\CreateGallery::route('/create'),
            'view' => Pages\ViewGallery::route('/{record}'),
            'edit' => Pages\EditGallery::route('/{record}/edit'),
        ];
    }
}
