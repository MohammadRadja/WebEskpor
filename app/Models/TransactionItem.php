<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TransactionItem extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['transaction_id', 'product_id', 'qty', 'unit_price', 'subtotal'];

    protected static function boot()
    {
        parent::boot();
        static::creating(fn ($model) => $model->id = (string) Str::uuid());
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
