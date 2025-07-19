<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProdukEksternal extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'produk_eksternal';

    protected $fillable = [
        'nama_supplier', 'kontak', 'id_produk',
        'jenis_perjanjian', 'komisi', 'harga_satuan',
        'jumlah', 'tanggal_pembelian', 'total_harga'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(fn ($model) => $model->id = (string) Str::uuid());
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}
