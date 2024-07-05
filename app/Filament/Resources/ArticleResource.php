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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(3)
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->columnSpan(2)
                    ->label('Judul')
                    ->maxLength(255)
                    ->required(),
                Forms\Components\Select::make('status')
                    ->columnSpan(1)
                    ->label('Status')
                    ->default('published')
                    ->options([
                        'published' => 'Terbitkan (bisa dibaca oleh siapapun)',
                        'draft' => 'Draf (simpan artikel untuk dilanjutkan nanti)',
                    ])
                    ->required(),
                FileUpload::make('thumbnail')
                    ->columnSpan(3)
                    ->disk('thumbnails')
                    ->label('Gambar sampul (cover)')
                    ->required(),
                Forms\Components\RichEditor::make('content')
                    ->columnSpan(3)
                    ->label('Konten')
                    ->default('Tulis konten artikelnya disini...')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'create' => Pages\CreateArticle::route('/create'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
        ];
    }
}
