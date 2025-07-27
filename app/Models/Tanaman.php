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
        'nama', 'jenis', 'id_bibit', 'sumber', 'sumber_eksternal'
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
        return $this->hasMany(PetakKebun::class, 'id_tanaman');
    }

    public function produk()
    {
        return $this->hasOne(Produk::class);
    }
}
