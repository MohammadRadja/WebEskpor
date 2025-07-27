<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Cart extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id', 'user_id'];

    // Auto generate UUID saat membuat cart
    protected static function booted()
    {
        static::creating(function ($cart) {
            $cart->id = (string) Str::uuid();
        });
    }

    // Relasi: Cart dimiliki oleh 1 user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Cart memiliki banyak item
    public function items()
    {
        return $this->hasMany(CartItem::class);
    }
}
