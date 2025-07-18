<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class News extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['title', 'slug', 'image_url'];

    protected static function boot()
    {
        parent::boot();
        static::creating(fn ($model) => $model->id = (string) Str::uuid());
    }
}
