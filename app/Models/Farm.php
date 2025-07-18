<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Farm extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['name', 'location'];

    protected static function boot()
    {
        parent::boot();
        static::creating(fn ($model) => $model->id = (string) Str::uuid());
    }

    public function plots()
    {
        return $this->hasMany(FarmPlot::class);
    }
}
