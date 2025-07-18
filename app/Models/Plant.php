<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Plant extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['name', 'type', 'harvest_stock', 'seed_id', 'source', 'external_source'];

    protected static function boot()
    {
        parent::boot();
        static::creating(fn ($model) => $model->id = (string) Str::uuid());
    }

    public function seed()
    {
        return $this->belongsTo(Seed::class);
    }

    public function plots()
    {
        return $this->hasMany(FarmPlot::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
