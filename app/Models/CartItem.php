<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CartItem extends Model
{
    use HasFactory;
    
    protected $keyType = 'string';  // Penting untuk UUID
    public $incrementing = false;
    protected $fillable = ['id', 'cart_id', 'produk_id', 'quantity'];

    protected static function booted()
    {
        static::creating(function ($cart) {
            $cart->id = (string) Str::uuid();
        });
    }
    // Relasi: Item ini milik 1 cart
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    // Relasi: Item ini mengacu ke 1 produk
    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}
