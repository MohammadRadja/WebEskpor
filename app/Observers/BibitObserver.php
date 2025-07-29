<?php

namespace App\Observers;

use App\Models\Bibit;

class BibitObserver
{

    public function created(Bibit $bibit)
    {
        $tanaman = $bibit->tanaman;
        if ($tanaman) {
            $tanaman->stok_bibit += $bibit->jumlah;
            $tanaman->save();
        }
    }

    public function updating(Bibit $bibit)
    {
        // Ambil nilai lama jumlah sebelum update
        $oldJumlah = $bibit->getOriginal('jumlah');

        $tanaman = $bibit->tanaman;
        if ($tanaman) {
            // Kurangi stok lama, lalu tambahkan stok baru
            $tanaman->stok_bibit = ($tanaman->stok_bibit - $oldJumlah) + $bibit->jumlah;
            $tanaman->save();
        }
    }

    public function deleted(Bibit $bibit)
    {
        $tanaman = $bibit->tanaman;
        if ($tanaman) {
            $tanaman->stok_bibit -= $bibit->jumlah;
            $tanaman->save();
        }
    }
}
