<?php

namespace App\Observers;

use App\Models\Transaksi;

class TransaksiObserver
{
    public function saving(Transaksi $transaksi)
    {
        if (!empty($transaksi->bukti_pembayaran) && $transaksi->status === 'menunggu') {
            $transaksi->status = 'proses';
        }
    }
}
