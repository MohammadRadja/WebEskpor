<?php

namespace App\Exports;

use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCharts;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Chart\Chart;
use PhpOffice\PhpSpreadsheet\Chart\DataSeries;
use PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues;
use PhpOffice\PhpSpreadsheet\Chart\Legend;
use PhpOffice\PhpSpreadsheet\Chart\PlotArea;
use PhpOffice\PhpSpreadsheet\Chart\Title;
use Carbon\Carbon;

class TransaksiExport implements FromCollection, WithHeadings, WithCharts, WithEvents
{
    protected $dataMingguan;
    protected $dataBulanan;

    public function __construct()
    {
        // Data mingguan - akumulasi per minggu
        $dataMingguanRaw = Transaksi::whereNotNull('created_at')
            ->where('created_at', '>=', now()->subDays(7))
            ->select(DB::raw('DATE(created_at) as tanggal'), DB::raw('SUM(total_harga) as total_nominal'))
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        // Akumulasi berdasarkan minggu ke-x
        $dataMingguanGrouped = [];

        foreach ($dataMingguanRaw as $item) {
            $date = Carbon::parse($item->tanggal);
            $weekOfMonth = ceil($date->day / 7);
            $key = "Minggu ke-$weekOfMonth";

            if (!isset($dataMingguanGrouped[$key])) {
                $dataMingguanGrouped[$key] = 0;
            }
            $dataMingguanGrouped[$key] += $item->total_nominal;
        }

        $this->dataMingguan = collect([]);
        foreach ($dataMingguanGrouped as $periode => $total) {
            $this->dataMingguan->push(
                (object) [
                    'periode' => $periode,
                    'total_nominal' => $total,
                ],
            );
        }

        // Data bulanan - akumulasi per bulan
        $dataBulananRaw = Transaksi::whereNotNull('created_at')
            ->where('created_at', '>=', now()->subMonths(12))
            ->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as periode'), DB::raw('SUM(total_harga) as total_nominal'))
            ->groupBy('periode')
            ->orderBy('periode')
            ->get();

        $dataBulananGrouped = [];
        foreach ($dataBulananRaw as $item) {
            $date = Carbon::createFromFormat('Y-m', $item->periode);
            $month = $date->month;
            $key = "Bulan ke-$month";

            if (!isset($dataBulananGrouped[$key])) {
                $dataBulananGrouped[$key] = 0;
            }
            $dataBulananGrouped[$key] += $item->total_nominal;
        }

        $this->dataBulanan = collect([]);
        foreach ($dataBulananGrouped as $periode => $total) {
            $this->dataBulanan->push(
                (object) [
                    'periode' => $periode,
                    'total_nominal' => $total,
                ],
            );
        }
    }

    public function collection()
    {
        $rows = [];

        // Judul dan periode (baris 1 dan 2)
        $rows[] = ['Laporan Transaksi Penjualan'];
        $rows[] = ['Periode: ' . now()->subMonths(12)->format('d M Y') . ' - ' . now()->format('d M Y')];
        $rows[] = [];

        // Header Mingguan (baris 4)
        $rows[] = $this->headings();

        // Data Mingguan (mulai baris 5)
        foreach ($this->dataMingguan as $item) {
            $rows[] = [$item->periode, $item->total_nominal, 'Mingguan'];
        }

        // Total Mingguan
        $rows[] = ['Total Mingguan', $this->dataMingguan->sum('total_nominal')];

        $rows[] = [];

        // Header Bulanan (setelah total mingguan + 2 baris kosong)
        $rows[] = $this->headings();

        // Data Bulanan
        foreach ($this->dataBulanan as $item) {
            $rows[] = [$item->periode, $item->total_nominal, 'Bulanan'];
        }

        // Total Bulanan
        $rows[] = ['Total Bulanan', $this->dataBulanan->sum('total_nominal')];

        return collect($rows);
    }

    public function headings(): array
    {
        return ['Periode', 'Total Transaksi', 'Keterangan'];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Style judul dan subjudul (baik mingguan dan bulanan)
                $sheet->mergeCells('A1:C1');
                $sheet->setCellValue('A1', 'Laporan Transaksi Penjualan PT. Rajawali Prima Andalas');
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FF2F4F4F'));
                $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getRowDimension(1)->setRowHeight(30);
                $sheet->getStyle('A1:C1')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

                $sheet->mergeCells('A2:C2');
                $sheet->setCellValue('A2', 'Periode: ' . now()->subMonths(12)->format('d M Y') . ' - ' . now()->format('d M Y'));

                $sheet->getStyle('A2')->getFont()->setItalic(true)->setSize(12)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FF696969'));
                $sheet->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getRowDimension(2)->setRowHeight(20);

                // Tentukan baris header, data dan total
                $headerMingguanRow = 4;
                $startMingguan = 5;
                $endMingguan = $startMingguan + $this->dataMingguan->count() - 1;
                $totalMingguanRow = $endMingguan + 1;

                $headerBulananRow = $totalMingguanRow + 1;
                $startBulanan = $headerBulananRow + 1;
                $endBulanan = $startBulanan + $this->dataBulanan->count() - 1;
                $totalBulananRow = $endBulanan + 1;

                // Warna header mingguan
                $headerFillMingguan = [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFD9E1F2'], // biru muda untuk mingguan
                ];

                // Warna header bulanan
                $headerFillBulanan = [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFDFF2DC'], // hijau muda untuk bulanan
                ];

                // Warna total mingguan
                $totalFillMingguan = [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFB0C4DE'], // warna biru soft untuk total mingguan
                ];

                // Warna total bulanan
                $totalFillBulanan = [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF90EE90'], // warna hijau soft untuk total bulanan
                ];

                // Terapkan style header mingguan
                $sheet->getStyle("A{$headerMingguanRow}:C{$headerMingguanRow}")->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['argb' => 'FF1F497D'],
                        'size' => 12,
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                    'fill' => $headerFillMingguan,
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => 'FFB7C9E2'],
                        ],
                    ],
                ]);
                $sheet->getRowDimension($headerMingguanRow)->setRowHeight(22);

                // Terapkan style header bulanan
                $sheet->getStyle("A{$headerBulananRow}:C{$headerBulananRow}")->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['argb' => 'FF1F497D'],
                        'size' => 12,
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                    'fill' => $headerFillBulanan,
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => 'FF1F497D'],
                        ],
                    ],
                ]);
                $sheet->getRowDimension($headerBulananRow)->setRowHeight(22);

                // Style total mingguan
                $sheet->getStyle("A{$totalMingguanRow}:C{$totalMingguanRow}")->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['argb' => 'FF0B3861'],
                    ],
                    'fill' => $totalFillMingguan,
                    'borders' => [
                        'top' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                            'color' => ['argb' => 'FF8EA9DB'],
                        ],
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                ]);
                $sheet
                    ->getStyle("A{$totalMingguanRow}")
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet
                    ->getStyle("B{$totalMingguanRow}:C{$totalMingguanRow}")
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                // Style total bulanan
                $sheet->getStyle("A{$totalBulananRow}:C{$totalBulananRow}")->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['argb' => 'FF0B3861'],
                    ],
                    'fill' => $totalFillBulanan,
                    'borders' => [
                        'top' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                            'color' => ['argb' => 'FF8EA9DB'],
                        ],
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                ]);
                $sheet
                    ->getStyle("A{$totalBulananRow}")
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet
                    ->getStyle("B{$totalBulananRow}:C{$totalBulananRow}")
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                // Format kolom nominal sebagai number dengan pemisah ribuan (kolom B)
                $lastRow = $totalBulananRow;
                $sheet
                    ->getStyle("B5:B{$lastRow}")
                    ->getNumberFormat()
                    ->setFormatCode('#,##0');

                // Auto size kolom A, B, C dan max width 30
                foreach (range('A', 'C') as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                    if ($sheet->getColumnDimension($col)->getWidth() > 30) {
                        $sheet->getColumnDimension($col)->setWidth(30);
                    }
                }

                // Padding kolom A dan C
                $sheet
                    ->getStyle("A5:A{$lastRow}")
                    ->getAlignment()
                    ->setIndent(1);
                $sheet
                    ->getStyle("C5:C{$lastRow}")
                    ->getAlignment()
                    ->setIndent(1);
            },
        ];
    }

    public function charts()
    {
        $sheetName = 'Worksheet';

        Carbon::setLocale('id');
        $bulanSekarang = Carbon::now()->isoFormat('MMMM');
        $tahunSekarang = Carbon::now()->year;

        // Sesuaikan chart range karena ada baris judul dan header
        $startRowMingguan = 5;
        $endRowMingguan = $startRowMingguan + $this->dataMingguan->count() - 1;

        $startRowBulanan = $endRowMingguan + 3; // total mingguan (1 row) + 1 kosong + header bulanan (1 row)
        $endRowBulanan = $startRowBulanan + $this->dataBulanan->count() - 1;

        // DataSeriesValues label dan value Mingguan
        $labelsMingguan = [new DataSeriesValues('String', "{$sheetName}!\$A\${$startRowMingguan}:\$A\${$endRowMingguan}", null, $this->dataMingguan->count())];
        $valuesMingguan = [new DataSeriesValues('Number', "{$sheetName}!\$B\${$startRowMingguan}:\$B\${$endRowMingguan}", null, $this->dataMingguan->count())];

        $seriesMingguan = new DataSeries(DataSeries::TYPE_BARCHART, DataSeries::GROUPING_CLUSTERED, range(0, count($valuesMingguan) - 1), [], $labelsMingguan, $valuesMingguan, null, 'Total Transaksi Mingguan');
        $seriesMingguan->setPlotDirection(DataSeries::DIRECTION_COL);

        $plotAreaMingguan = new PlotArea(null, [$seriesMingguan]);
        $chartMingguan = new Chart('chart_mingguan', new Title("Grafik Nominal Transaksi Bulan $bulanSekarang"), new Legend(Legend::POSITION_RIGHT, null, false), $plotAreaMingguan);
        $chartMingguan->setTopLeftPosition('E2');
        $chartMingguan->setBottomRightPosition('M20');

        // Bulanan
        $labelsBulanan = [new DataSeriesValues('String', "{$sheetName}!\$A\${$startRowBulanan}:\$A\${$endRowBulanan}", null, $this->dataBulanan->count())];
        $valuesBulanan = [new DataSeriesValues('Number', "{$sheetName}!\$B\${$startRowBulanan}:\$B\${$endRowBulanan}", null, $this->dataBulanan->count())];

        $seriesBulanan = new DataSeries(DataSeries::TYPE_BARCHART, DataSeries::GROUPING_CLUSTERED, range(0, count($valuesBulanan) - 1), [], $labelsBulanan, $valuesBulanan, null, 'Total Transaksi Bulanan');
        $seriesBulanan->setPlotDirection(DataSeries::DIRECTION_COL);

        $plotAreaBulanan = new PlotArea(null, [$seriesBulanan]);
        $chartBulanan = new Chart('chart_bulanan', new Title("Grafik Nominal Transaksi Tahun $tahunSekarang"), new Legend(Legend::POSITION_RIGHT, null, false), $plotAreaBulanan);
        $chartBulanan->setTopLeftPosition('E22');
        $chartBulanan->setBottomRightPosition('M40');

        return [$chartMingguan, $chartBulanan];
    }
}
