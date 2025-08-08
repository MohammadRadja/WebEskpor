<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Produk;
use App\Models\ProdukEksternal;
use App\Models\Transaksi;
use App\Models\Kebun;
use App\Models\PetakKebun;
use App\Models\Tanaman;
use App\Models\Bibit;
use App\Models\Konten;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik utama
        $totalUsers = User::count();
        $totalProduk = Produk::count();
        $totalProdukEksternal = ProdukEksternal::count();
        $totalTransaksi = Transaksi::count();
        $totalKebun = Kebun::count();
        $totalPetak = PetakKebun::count();
        $totalBibit = Bibit::whereYear('tanggal_pembelian', now()->year)->whereMonth('tanggal_pembelian', now()->month)->sum('jumlah');
        $totalKonten = Konten::count();
        $totalPendapatan = Transaksi::sum('total_harga');
        $totalPengeluaran = Bibit::whereMonth('tanggal_pembelian', now()->month)->sum(DB::raw('harga_satuan*jumlah')) + ProdukEksternal::whereMonth('tanggal_pembelian', now()->month)->sum('total_harga');
        $totalPanen = PetakKebun::whereMonth('created_at', now()->month)->sum('jumlah_panen');

        // Data Chart Keuangan
        $chartData = Transaksi::selectRaw(
            'DATE_FORMAT(created_at, "%M %Y") as bulan,
                        SUM(total_harga) as pendapatan',
        )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('bulan')
            ->orderByRaw('MIN(created_at)')
            ->get()
            ->map(function ($item) {
                return [
                    'bulan' => $item->bulan,
                    'pendapatan' => (float) $item->pendapatan,
                    'pengeluaran' => (float) Bibit::whereMonth('tanggal_pembelian', now()->month)->sum(DB::raw('harga_satuan*jumlah')) + (float) ProdukEksternal::whereMonth('tanggal_pembelian', now()->month)->sum('total_harga'),
                    'bersih' => (float) $item->pendapatan - ((float) Bibit::whereMonth('tanggal_pembelian', now()->month)->sum(DB::raw('harga_satuan*jumlah')) + (float) ProdukEksternal::whereMonth('tanggal_pembelian', now()->month)->sum('total_harga')),
                ];
            });

        // Data Chart Panen & Tanaman
        $chartPanenTanaman = collect(range(0, 5))
            ->map(function ($i) {
                $tanggal = now()->subMonths($i);
                return [
                    'bulan' => $tanggal->translatedFormat('F Y'),
                    'panen' => (int) PetakKebun::whereYear('tanggal_panen', $tanggal->year)->whereMonth('tanggal_panen', $tanggal->month)->sum('jumlah_panen'),
                    'bibit' => (int) Bibit::whereYear('tanggal_pembelian', $tanggal->year)->whereMonth('tanggal_pembelian', $tanggal->month)->sum('jumlah'),
                    'eksternal' => (int) ProdukEksternal::whereYear('tanggal_pembelian', $tanggal->year)->whereMonth('tanggal_pembelian', $tanggal->month)->sum('jumlah'),
                ];
            })
            ->reverse()
            ->values();

        // Log Aktivitas
        $logs = DB::table('activity_log')->latest()->limit(10)->get();

        return view('dashboard.index', compact('totalUsers', 'totalProduk', 'totalProdukEksternal', 'totalTransaksi', 'totalPendapatan', 'totalKebun', 'totalPetak', 'totalBibit', 'totalKonten', 'totalPengeluaran', 'totalPanen', 'chartData', 'chartPanenTanaman', 'logs'));
    }
}
