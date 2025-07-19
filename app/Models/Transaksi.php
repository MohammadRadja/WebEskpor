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
        'nama_pembeli', 'telepon', 'alamat', 'negara', 'biaya_pengiriman',
        'jumlah', 'total_harga', 'bukti_pembayaran', 'status', 'subtotal', 'user_id'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(fn ($model) => $model->id = (string) Str::uuid());
    }

    public function pengguna()
    {
        return $this->belongsTo(User::class);
    }

    public function detailTransaksi()
    {
        return $this->hasMany(detailTransaksi::class);
    }
}
