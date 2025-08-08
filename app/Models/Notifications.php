<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Notifications extends Model
{
    protected $keyType = 'string';
public $incrementing = false;
    protected $table = 'notifications';

    protected $fillable = ['user_id', 'title', 'message', 'type', 'is_read','id_transaksi'];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(fn($model) => ($model->id = (string) Str::uuid()));
    }
}
