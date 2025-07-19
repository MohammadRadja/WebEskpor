<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Berita extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'berita';

    protected $fillable = ['judul', 'slug', 'image_url'];

    protected static function boot()
    {
        parent::boot();
        static::creating(fn ($model) => $model->id = (string) Str::uuid());
    }
}
