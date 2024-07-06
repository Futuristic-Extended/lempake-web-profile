<?php

namespace App\Models;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'writer_id',
        'thumbnail_sm_filename',
        'thumbnail_lg_filename',
        'title',
        'content',
        'status'
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($article) {
            if ($article->thumbnail_sm_filename && Storage::disk('thumbnails')->exists($article->thumbnail_sm_filename)) {
                Storage::disk('thumbnails')->delete($article->thumbnail_sm_filename);
            }

            if ($article->thumbnail_lg_filename && Storage::disk('thumbnails')->exists($article->thumbnail_lg_filename)) {
                Storage::disk('thumbnails')->delete($article->thumbnail_lg_filename);
            }
        });
    }

    public function user() {
        return $this->belongsTo(User::class, 'writer_id');
    }
}
