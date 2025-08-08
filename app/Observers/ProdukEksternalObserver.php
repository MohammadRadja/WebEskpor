<?php

namespace App\Observers;

use App\Models\ProdukEksternal;
use App\Models\Tanaman;

class ProdukEksternalObserver
{
    public function created(ProdukEksternal $produkEksternal)
    {
        $this->updateStokTanaman($produkEksternal->id_tanaman);
    }

    public function updated(ProdukEksternal $produkEksternal)
    {
        // Tidak perlu hitung selisih, cukup sinkronisasi total
        $this->updateStokTanaman($produkEksternal->id_tanaman);
    }

    public function deleted(ProdukEksternal $produkEksternal)
    {
        $this->updateStokTanaman($produkEksternal->id_tanaman);
    }

    private function updateStokTanaman(string $idTanaman): void
    {
        $tanaman = Tanaman::find($idTanaman);
        if ($tanaman) {
            $tanaman->sinkronisasiStokBarangJadi();
        }
    }
}
