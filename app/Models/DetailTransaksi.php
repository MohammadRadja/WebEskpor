<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class DetailTransaksi extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'detail_transaksi';

    protected $fillable = [
        'id_transaksi', 'id_produk', 'jumlah', 'harga_satuan', 'subtotal'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(fn ($model) => $model->id = (string) Str::uuid());
    }

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}
