<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GalleryImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'gallery_id',
        'image_sm_filename',
        'image_lg_filename'
    ];

    public function gallery(): BelongsTo {
        return $this->belongsTo(Gallery::class, 'gallery_id');
    }
}
