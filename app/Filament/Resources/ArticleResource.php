<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleResource\Pages;
use App\Filament\Resources\ArticleResource\RelationManagers;
use App\Models\Article;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\BaseFileUpload;
use Filament\Resources\Pages\Page;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Contracts\View\View;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use stdClass;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel = 'Artikel';

    protected static ?string $pluralModelLabel = 'Artikel';

    protected static ?string $breadcrumb = 'Artikel';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(3)
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->columnSpan(2)
                    ->label('Judul')
                    ->maxLength(150)
                    ->required()
                    ->validationMessages([
                        'required' => 'Mohon isi judul artikel'
                    ]),
                Forms\Components\Select::make('status')
                    ->columnSpan(1)
                    ->label('Status')
                    ->default('published')
                    ->selectablePlaceholder(false)
                    ->options([
                        'published' => 'Terbitkan (bisa langsung dibaca secara publik)',
                        'draft' => 'Draf (simpan artikel untuk ditulis nanti)',
                    ])
                    ->validationMessages([
                        'required' => 'Mohon pilih status artikel'
                    ]),
                FileUpload::make('thumbnail')
                    ->columnSpan(3)
                    ->disk('thumbnails')
                    ->label('Gambar sampul (cover)')
                    ->uploadingMessage('Mengunggah gambar')
                    ->maxSize(5000)
                    ->required(fn (Page $livewire): bool => $livewire instanceof Pages\CreateArticle)
                    ->validationMessages([
                        'required' => 'Mohon masukkan sampul (gambar atau foto) artikel'
                    ])
                    ->acceptedFileTypes(['image/jpg', 'image/jpeg', 'image/png'])
                    ->placeholder('Masukkan sampul artikel di sini, gambar sampul hanya boleh bertipe jpg, jpeg, atau png.'),
                Forms\Components\RichEditor::make('content')
                    ->columnSpan(3)
                    ->label('Konten')
                    ->default('Tulis konten artikelnya disini...')
                    ->required()
                    ->validationMessages([
                        'required' => 'Mohon isi konten dari artikel'
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('#')->rowIndex(),
                ImageColumn::make('thumbnail_sm_filename')
                    ->disk('thumbnails')
                    ->label('Sampul')
                    ->width(208)
                    ->height(139),
                TextColumn::make('title')
                    ->label('Judul'),
                TextColumn::make('status')
                    ->formatStateUsing(function (string $state): string {
                        return $state == 'published' ? 'Terbit' : 'Masih disimpan';
                    })
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'warning',
                        'published' => 'success'
                    })
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Baca artikel'),
                Tables\Actions\EditAction::make()
                    ->label('Tulis ulang'),
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
            'index' => Pages\ListArticles::route('/'),
            'view' => Pages\ViewArticle::route('/{record}'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
        ];
    }
}
