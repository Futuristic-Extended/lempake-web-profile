<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'uploader_id',
        'title',
        'description'
    ];

    public function uploader(): BelongsTo {
        return $this->belongsTo(User::class, 'uploader_id');
    }

    public function images(): HasMany {
        return $this->hasMany(GalleryImage::class, 'gallery_id');
    }
}
