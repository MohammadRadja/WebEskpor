<?php

namespace App\Observers;

use App\Models\Bibit;
use App\Models\Tanaman;
use App\Models\PetakKebun;

class BibitObserver
{
    public function updating(Bibit $bibit)
    {
        if ($bibit->isDirty('jumlah')) {
            $oldQty = $bibit->getOriginal('jumlah');
            $newQty = $bibit->jumlah;
            $selisih = $newQty - $oldQty;

            $tanaman = Tanaman::where('id_bibit', $bibit->id)->first();

            if (!$tanaman) {
                return;
            }

            $petakKebun = PetakKebun::where('id_tanaman', $tanaman->id)->first();

            if (!$petakKebun) {
                return;
            }

            $petakKebun->jumlah_tanaman += $selisih;
            $petakKebun->save();
        }
    }
}
