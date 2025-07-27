<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Bibit extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'bibit';

    // Daftar kolom yang boleh diisi secara massal
    protected $fillable = ['nama', 'tanggal_pembelian', 'nama_penjual', 'harga_satuan', 'jumlah', 'total_harga'];

    public function getJumlahTerpakaiAttribute()
    {
        return $this->tanaman->sum(function ($t) {
            return $t->petakKebun->sum('jumlah_tanaman');
        });
    }

    public function getJumlahSisaAttribute()
    {
        return $this->jumlah - $this->jumlah_terpakai;
    }

    // Membuat UUID secara otomatis saat membuat data baru
    protected static function boot()
    {
        parent::boot();
        static::creating(fn($model) => ($model->id = (string) Str::uuid()));
    }

    // Relasi ke tanaman
    public function tanaman()
    {
        return $this->hasMany(Tanaman::class, 'id_bibit');
    }
}
