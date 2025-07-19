<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Produk extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'produk';

    protected $fillable = ['deskripsi', 'gambar', 'tanaman_id'];

    protected static function boot()
    {
        parent::boot();
        static::creating(fn($model) => ($model->id = (string) Str::uuid()));
    }

    public function tanaman()
    {
        return $this->belongsTo(Tanaman::class);
    }

    public function detailTransaksi()
    {
        return $this->hasMany(detailTransaksi::class);
    }

    public function produkEksternal()
    {
        return $this->hasMany(ProdukEksternal::class);
    }
}
