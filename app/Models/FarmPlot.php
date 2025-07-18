<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class FarmPlot extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name', 'size', 'responsible_person', 'status',
        'farm_id', 'plant_id', 'planting_date', 'plant_quantity', 'harvest_quantity'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(fn ($model) => $model->id = (string) Str::uuid());
    }

    public function farm()
    {
        return $this->belongsTo(Farm::class);
    }

    public function plant()
    {
        return $this->belongsTo(Plant::class);
    }
}
