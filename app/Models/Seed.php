<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Seed extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['purchase_date', 'seller_name', 'unit_price', 'quantity', 'total_price'];

    protected static function boot()
    {
        parent::boot();
        static::creating(fn ($model) => $model->id = (string) Str::uuid());
    }

    public function plants()
    {
        return $this->hasMany(Plant::class);
    }
}
