<?php

namespace App\Filament\Resources\ArticleResource\Pages;

use App\Filament\Resources\ArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\Support\Htmlable;

class ViewArticle extends ViewRecord
{
    protected static string $resource = ArticleResource::class;

    protected static string $view = 'filament.articles.view';

    public function getBreadcrumb(): string
    {
        return $this->record->title;
    }

    public function getTitle(): string | Htmlable
    {
        return $this->record->title;
    }
}
