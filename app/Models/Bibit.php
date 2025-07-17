<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bibit extends Model
{
    protected $fillable = [
        'tanggal_beli',
        'nama_penjual',
        'harga_satuan',
        'qty',
        'total_harga',
    ];
}
