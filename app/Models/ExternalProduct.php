<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ExternalProduct extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'supplier_name', 'contact', 'product_id',
        'agreement_type', 'commission', 'unit_price',
        'quantity', 'purchase_date', 'total_price'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(fn ($model) => $model->id = (string) Str::uuid());
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
