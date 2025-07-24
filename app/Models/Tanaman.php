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
        'nama', 'jenis', 'stok_panen', 'id_bibit', 'asal', 'asal_eksternal'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(fn ($model) => $model->id = (string) Str::uuid());
    }

    public function bibit()
    {
        return $this->belongsTo(Bibit::class, 'id_bibit');
    }

    public function petakKebun()
    {
        return $this->hasOne(PetakKebun::class);
    }

    public function produk()
    {
        return $this->hasOne(Produk::class);
    }
}
