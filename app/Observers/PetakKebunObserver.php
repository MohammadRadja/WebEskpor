<?php

namespace App\Observers;

use App\Models\PetakKebun;
use App\Models\Tanaman;

class PetakKebunObserver
{
    public function created(PetakKebun $petakKebun)
    {
        if (!is_null($petakKebun->jumlah_tanaman) && $petakKebun->jumlah_tanaman > 0) {
            $this->kurangiStokBibit($petakKebun->id_tanaman, $petakKebun->jumlah_tanaman);
        }

        $this->updateStokTanaman($petakKebun->id_tanaman);
    }

    public function updated(PetakKebun $petakKebun)
    {
        if ($petakKebun->wasChanged('jumlah_tanaman')) {
            $originalJumlah = $petakKebun->getOriginal('jumlah_tanaman') ?? 0;
            $newJumlah = $petakKebun->jumlah_tanaman ?? 0;

            $selisih = $newJumlah - $originalJumlah;
            if ($selisih > 0) {
                $this->kurangiStokBibit($petakKebun->id_tanaman, $selisih);
            }
        }

        if ($petakKebun->wasChanged('jumlah_panen') || $petakKebun->wasChanged('status')) {
            $this->updateStokTanaman($petakKebun->id_tanaman);
        }
    }

    public function deleted(PetakKebun $petakKebun)
    {
        if (!is_null($petakKebun->jumlah_tanaman) && $petakKebun->jumlah_tanaman > 0) {
            $this->tambahStokBibit($petakKebun->id_tanaman, $petakKebun->jumlah_tanaman);
        }

        $this->updateStokTanaman($petakKebun->id_tanaman);
    }

    public function restored(PetakKebun $petakKebun)
    {
        $this->updateStokTanaman($petakKebun->id_tanaman);
    }

    private function updateStokTanaman(string $idTanaman): void
    {
        $tanaman = Tanaman::find($idTanaman);
        if ($tanaman) {
            $tanaman->sinkronisasiStokBarangJadi();
        }
    }

    private function kurangiStokBibit(string $idTanaman, int $jumlah): void
    {
        $tanaman = Tanaman::find($idTanaman);
        if ($tanaman) {
            $tanaman->stok_bibit = max(0, ($tanaman->stok_bibit ?? 0) - $jumlah);
            $tanaman->save();
        }
    }

    private function tambahStokBibit(string $idTanaman, int $jumlah): void
    {
        $tanaman = Tanaman::find($idTanaman);
        if ($tanaman) {
            $tanaman->stok_bibit = ($tanaman->stok_bibit ?? 0) + $jumlah;
            $tanaman->save();
        }
    }
}
