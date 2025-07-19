<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PetakKebun extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'petak_kebun';

    protected $fillable = ['nama', 'ukuran', 'penanggung_jawab', 'status', 'id_kebun', 'id_tanaman', 'tanggal_tanam', 'jumlah_tanaman', 'jumlah_panen'];

    protected static function boot()
    {
        parent::boot();
        static::creating(fn($model) => ($model->id = (string) Str::uuid()));
    }

    public function kebun()
    {
        return $this->belongsTo(Kebun::class);
    }

    public function tanaman()
    {
        return $this->belongsTo(Tanaman::class);
    }
}
