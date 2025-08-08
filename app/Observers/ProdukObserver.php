<?php

namespace App\Observers;

use App\Models\Produk;
use App\Models\Tanaman;
use Illuminate\Support\Facades\Log;

class ProdukObserver
{
    public function creating(Produk $produk)
    {
        if ($produk->id_tanaman) {
            $tanaman = Tanaman::find($produk->id_tanaman);

            if ($tanaman) {
                $produk->stok = $tanaman->stok_barang_jadi ?? 0;
            }
        }
    }

    public function updating(Produk $produk)
    {
        if ($produk->isDirty('stok')) {
            $oldStok = $produk->getOriginal('stok');
            $newStok = $produk->stok;
            $selisih = $newStok - $oldStok;

            $tanaman = Tanaman::find($produk->id_tanaman);
            if ($tanaman) {
                $tanaman->stok_barang_jadi += $selisih;
                if ($tanaman->stok_barang_jadi < 0) {
                    $tanaman->stok_barang_jadi = 0;
                }
                $tanaman->saveQuietly();
            }
        }
    }

}
