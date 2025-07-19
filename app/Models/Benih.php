<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Benih extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'benih';

    // Daftar kolom yang boleh diisi secara massal
    protected $fillable = [
        'tanggal_pembelian',
        'nama_penjual',
        'harga_satuan',
        'jumlah',
        'total_harga'
    ];

    // Membuat UUID secara otomatis saat membuat data baru
    protected static function boot()
    {
        parent::boot();
        static::creating(fn ($model) => $model->id = (string) Str::uuid());
    }

    // Relasi ke tanaman
    public function tanaman()
    {
        return $this->hasMany(Tanaman::class);
    }
}
