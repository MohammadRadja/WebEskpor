<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tanaman extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'tanaman';

    protected $fillable = [
        'nama', 'jenis', 'stok_panen', 'id_benih', 'asal', 'asal_eksternal'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(fn ($model) => $model->id = (string) Str::uuid());
    }

    public function benih()
    {
        return $this->belongsTo(Benih::class);
    }

    public function petakLahan()
    {
        return $this->hasMany(PetakLahan::class);
    }

    public function produk()
    {
        return $this->hasMany(Produk::class);
    }
}
