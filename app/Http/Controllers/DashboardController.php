<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Produk;
use App\Models\ProdukEksternal;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Kebun;
use App\Models\PetakKebun;
use App\Models\Tanaman;
use App\Models\Bibit;
use App\Models\Konten;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik
        $totalUsers = User::count();
        $totalProduk = Produk::count();
        $totalProdukEksternal = ProdukEksternal::count();
        $totalTransaksi = Transaksi::count();
        $totalPendapatan = Transaksi::sum('total_harga');
        $totalKebun = Kebun::count();
        $totalPetak = PetakKebun::count();
        $totalTanaman = Tanaman::count();
        $totalBibit = Bibit::count();
        $totalKonten = Konten::count();

        // Grafik: Jumlah Transaksi per Bulan (6 bulan terakhir)
        $transaksiBulanan = Transaksi::selectRaw('MONTH(created_at) as bulan, COUNT(*) as jumlah')
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        // Log Aktivitas Terbaru (jika ada tabel activity_log)
        $logs = DB::table('activity_log')->latest()->limit(10)->get();

        return view('dashboard.index', [
            'totalUsers' => $totalUsers,
            'totalProduk' => $totalProduk,
            'totalProdukEksternal' => $totalProdukEksternal,
            'totalTransaksi' => $totalTransaksi,
            'totalPendapatan' => $totalPendapatan,
            'totalKebun' => $totalKebun,
            'totalPetak' => $totalPetak,
            'totalTanaman' => $totalTanaman,
            'totalBibit' => $totalBibit,
            'totalKonten' => $totalKonten,
            'transaksiBulanan' => $transaksiBulanan,
            'logs' => $logs
        ]);
    }
}
