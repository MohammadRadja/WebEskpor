<?php

namespace App\Observers;

use App\Models\PetakKebun;
use App\Models\Produk;

class PetakKebunObserver
{
    public function created(PetakKebun $petakKebun)
    {
        $this->syncProdukStok($petakKebun->id_tanaman);
    }

    public function updated(PetakKebun $petakKebun)
    {
        // Jika jumlah_panen berubah atau status berubah, sinkronisasi stok
        if ($petakKebun->wasChanged('jumlah_panen') || $petakKebun->wasChanged('status')) {
            $this->syncProdukStok($petakKebun->id_tanaman);
        }
    }

    public function deleted(PetakKebun $petakKebun)
    {
        $this->syncProdukStok($petakKebun->id_tanaman);
    }

    public function restored(PetakKebun $petakKebun)
    {
        $this->syncProdukStok($petakKebun->id_tanaman);
    }

    private function syncProdukStok(string $idTanaman): void
    {
        // Hitung total panen untuk tanaman ini
        $totalPanen = PetakKebun::where('id_tanaman', $idTanaman)->sum('jumlah_panen');

        // Update semua produk yang menggunakan tanaman ini
        $produkList = Produk::where('id_tanaman', $idTanaman)->get();

        foreach ($produkList as $produk) {
            $produk->update(['stok' => $totalPanen]);
        }
    }
}
