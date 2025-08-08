<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tanaman extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'tanaman';

    protected $fillable = ['nama', 'jenis', 'stok_barang_jadi', 'stok_bibit'];

    protected static function boot()
    {
        parent::boot();
        static::creating(fn($model) => ($model->id = (string) Str::uuid()));
    }

    public function hitungTotalStokBarangJadi(): int
    {
        $totalEksternal = ProdukEksternal::where('id_tanaman', $this->id)->sum('jumlah');
        $totalPanen = PetakKebun::where('id_tanaman', $this->id)->sum('jumlah_panen');

        return $totalEksternal + $totalPanen;
    }

    public function sinkronisasiStokBarangJadi(): void
    {
        $this->stok_barang_jadi = $this->hitungTotalStokBarangJadi();
        $this->save();

        if ($this->produk) {
            $this->produk->stok = $this->stok_barang_jadi;
            $this->produk->saveQuietly();
        }
    }

    public function bibit()
    {
        return $this->hasOne(Bibit::class, 'id_tanaman');
    }

    public function petakKebun()
    {
        return $this->hasMany(PetakKebun::class, 'id_tanaman');
    }

    public function produk()
    {
        return $this->hasOne(Produk::class, 'id_tanaman');
    }

    public function produkEksternal()
    {
        return $this->hasOne(ProdukEksternal::class, 'id_tanaman');
    }
}
