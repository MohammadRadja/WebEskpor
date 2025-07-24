<?php

namespace App\Observers;

use App\Models\PetakKebun;
use App\Models\Produk;

class PetakKebunObserver
{
    public function updating(PetakKebun $petakKebun)
    {
        if ($petakKebun->isDirty('jumlah_panen')) {
            $old = $petakKebun->getOriginal('jumlah_panen');
            $new = $petakKebun->jumlah_panen;
            $selisih = $new - $old;

            $produk = Produk::where('id_tanaman', $petakKebun->id_tanaman)->first();
            if (!$produk) {
                return;
            }

            $produk->stok += $selisih;
            $produk->save();
        }
    }
}
