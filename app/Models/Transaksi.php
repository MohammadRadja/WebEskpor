<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Transaksi extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'transaksi';

    protected $fillable = [
        'telepon', 'alamat', 'negara', 'biaya_pengiriman',
        'jumlah', 'total_harga', 'bukti_pembayaran', 'status', 'id_pelanggan'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(fn ($model) => $model->id = (string) Str::uuid());
    }

    public function pelanggan()
    {
        return $this->belongsTo(User::class, 'id_pelanggan');
    }

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_transaksi');
    }
}
