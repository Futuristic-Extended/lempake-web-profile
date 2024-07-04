<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'writer_id',
        'thumbnail_sm_url',
        'thumbnail_lg_url',
        'title',
        'content',
        'status'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'writer_id');
    }
}
