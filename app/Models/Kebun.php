<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Kebun extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'kebun';

    protected $fillable = ['nama', 'lokasi'];

    protected static function boot()
    {
        parent::boot();
        static::creating(fn ($model) => $model->id = (string) Str::uuid());
    }

    public function petakKebun()
    {
        return $this->hasMany(PetakKebun::class);
    }
}
