<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['description', 'image', 'plant_id'];

    protected static function boot()
    {
        parent::boot();
        static::creating(fn ($model) => $model->id = (string) Str::uuid());
    }

    public function plant()
    {
        return $this->belongsTo(Plant::class);
    }

    public function transactionItems()
    {
        return $this->hasMany(TransactionItem::class);
    }

    public function externalProducts()
    {
        return $this->hasMany(ExternalProduct::class);
    }
}
