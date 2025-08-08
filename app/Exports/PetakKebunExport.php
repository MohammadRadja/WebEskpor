<?php

namespace App\Exports;

use App\Models\PetakKebun;
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

class PetakKebunExport implements FromCollection, WithHeadings, WithCharts, WithEvents
{
    protected $dataMingguan;
    protected $dataBulanan;

    public function __construct()
    {
        // --- Data Mingguan berdasarkan tanggal_tanam ---
        $rawMingguan = PetakKebun::whereNotNull('tanggal_tanam')
            ->where('tanggal_tanam', '>=', now()->startOfMonth()->subDays(30)) // 30 hari terakhir dari tanggal_tanam
            ->select(DB::raw('DATE(tanggal_tanam) as tanggal'), DB::raw('SUM(CAST(SUBSTRING_INDEX(ukuran, "x", 1) AS UNSIGNED) * CAST(SUBSTRING_INDEX(ukuran, "x", -1) AS UNSIGNED)) as total_ukuran'), DB::raw('SUM(jumlah_tanaman) as total_jumlah_tanaman'))
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        $groupMingguan = [];
        foreach ($rawMingguan as $item) {
            $date = Carbon::parse($item->tanggal);
            $weekOfMonth = ceil($date->day / 7);
            $key = "Minggu ke-$weekOfMonth";

            if (!isset($groupMingguan[$key])) {
                $groupMingguan[$key] = [
                    'total_ukuran' => 0,
                    'total_jumlah_tanaman' => 0,
                ];
            }

            $groupMingguan[$key]['total_ukuran'] += $item->total_ukuran;
            $groupMingguan[$key]['total_jumlah_tanaman'] += $item->total_jumlah_tanaman;
        }

        $this->dataMingguan = collect([]);
        foreach ($groupMingguan as $periode => $totals) {
            $this->dataMingguan->push(
                (object) [
                    'periode' => $periode,
                    'total_ukuran' => $totals['total_ukuran'],
                    'total_jumlah_tanaman' => $totals['total_jumlah_tanaman'],
                ],
            );
        }

        // --- Data Bulanan berdasarkan tanggal_tanam ---
        $rawBulanan = PetakKebun::whereNotNull('tanggal_tanam')
            ->where('tanggal_tanam', '>=', now()->subMonths(12)->startOfMonth())
            ->select(DB::raw('DATE_FORMAT(tanggal_tanam, "%Y-%m") as periode'), DB::raw('SUM(CAST(SUBSTRING_INDEX(ukuran, "x", 1) AS UNSIGNED) * CAST(SUBSTRING_INDEX(ukuran, "x", -1) AS UNSIGNED)) as total_ukuran'), DB::raw('SUM(jumlah_tanaman) as total_jumlah_tanaman'))
            ->groupBy('periode')
            ->orderBy('periode')
            ->get();

        $this->dataBulanan = collect([]);
        foreach ($rawBulanan as $item) {
            $date = Carbon::createFromFormat('Y-m', $item->periode);
            $monthName = $date->locale('id')->isoFormat('MMMM YYYY');
            $this->dataBulanan->push(
                (object) [
                    'periode' => $monthName,
                    'total_ukuran' => $item->total_ukuran,
                    'total_jumlah_tanaman' => $item->total_jumlah_tanaman,
                ],
            );
        }
    }

    public function collection()
    {
        $rows = [];

        $rows[] = ['Laporan Petak Kebun'];
        $rows[] = ['Periode: ' . now()->subYears(1)->format('d M Y') . ' - ' . now()->format('d M Y')];
        $rows[] = [];

        // Header Mingguan
        $rows[] = $this->headings();

        // Data Mingguan
        foreach ($this->dataMingguan as $item) {
            $rows[] = [$item->periode, $item->total_ukuran, $item->total_jumlah_tanaman, 'Mingguan'];
        }

        // Total Mingguan
        $rows[] = ['Total Mingguan', $this->dataMingguan->sum('total_ukuran'), $this->dataMingguan->sum('total_jumlah_tanaman'), ''];

        $rows[] = [];

        // Header Tahunan
        $rows[] = $this->headings();

        // Data Tahunan
        foreach ($this->dataBulanan as $item) {
            $rows[] = [$item->periode, $item->total_ukuran, $item->total_jumlah_tanaman, 'Bulanan'];
        }

        // Total Tahunan
        $rows[] = ['Total Bulanan', $this->dataBulanan->sum('total_ukuran'), $this->dataBulanan->sum('total_jumlah_tanaman'), ''];

        return collect($rows);
    }

    public function headings(): array
    {
        return ['Periode', 'Total Ukuran (m2)', 'Total Jumlah Tanaman', 'Keterangan'];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Styling judul dan periode (sama seperti sebelumnya)
                $sheet->mergeCells('A1:D1');
                $sheet->setCellValue('A1', 'Laporan Petak Kebun PT. Rajawali Prima Andalas');
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FF2F4F4F'));
                $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getRowDimension(1)->setRowHeight(30);
                $sheet->getStyle('A1:C1')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

                $sheet->mergeCells('A2:D2');
                $sheet->setCellValue('A2', 'Periode: ' . now()->subMonths(12)->format('d M Y') . ' - ' . now()->format('d M Y'));

                $sheet->getStyle('A2')->getFont()->setItalic(true)->setSize(12)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FF696969'));
                $sheet->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getRowDimension(2)->setRowHeight(20);

                // Baris header mingguan dan bulanan
                $headerMingguanRow = 4;
                $startMingguan = 5;
                $endMingguan = $startMingguan + $this->dataMingguan->count() - 1;
                $totalMingguanRow = $endMingguan + 1;

                $headerBulananRow = $totalMingguanRow + 1;
                $startBulanan = $headerBulananRow + 1;
                $endBulanan = $startBulanan + $this->dataBulanan->count() - 1;
                $totalBulananRow = $endBulanan + 1;

                // Warna header dan total untuk mingguan dan bulanan
                $headerFillMingguan = [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFD9E1F2'], // biru muda
                ];
                $headerFillBulanan = [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFDFF2DC'], // hijau muda
                ];
                $totalFillMingguan = [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFB0C4DE'], // biru soft
                ];
                $totalFillBulanan = [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF90EE90'], // hijau soft
                ];

                // Style header mingguan
                $sheet->getStyle("A{$headerMingguanRow}:D{$headerMingguanRow}")->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['argb' => 'FF1F497D'], 'size' => 12],
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

                // Style header bulanan
                $sheet->getStyle("A{$headerBulananRow}:D{$headerBulananRow}")->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['argb' => 'FF1F497D'], 'size' => 12],
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
                $sheet->getStyle("A{$totalMingguanRow}:D{$totalMingguanRow}")->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['argb' => 'FF0B3861']],
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
                    ->getStyle("B{$totalMingguanRow}:D{$totalMingguanRow}")
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                // Style total bulanan
                $sheet->getStyle("A{$totalBulananRow}:D{$totalBulananRow}")->applyFromArray([
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
                    ->getStyle("B{$totalBulananRow}:D{$totalBulananRow}")
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                // Format kolom jumlah dan harga sebagai angka dengan pemisah ribuan (kolom B dan C)
                $sheet
                    ->getStyle("B{$startMingguan}:C{$totalBulananRow}")
                    ->getNumberFormat()
                    ->setFormatCode('#,##0');

                // Auto size kolom A-D dan batasi max width
                foreach (range('A', 'D') as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                    if ($sheet->getColumnDimension($col)->getWidth() > 30) {
                        $sheet->getColumnDimension($col)->setWidth(30);
                    }
                }
            },
        ];
    }

    public function charts()
    {
        $sheetName = 'Worksheet';

        Carbon::setLocale('id');
        $bulanSekarang = Carbon::now()->isoFormat('MMMM');
        $tahunSekarang = Carbon::now()->year;

        // Posisi data mingguan dan tahunan
        $startRowMingguan = 5;
        $endRowMingguan = $startRowMingguan + $this->dataMingguan->count() - 1;

        $startRowTahunan = $endRowMingguan + 3;
        $endRowTahunan = $startRowTahunan + $this->dataBulanan->count() - 1;

        // Chart Jumlah Tanaman Mingguan
        $labelsMingguan = [new DataSeriesValues('String', "{$sheetName}!\$A\${$startRowMingguan}:\$A\${$endRowMingguan}", null, $this->dataMingguan->count())];
        $valuesMingguanJumlah = [new DataSeriesValues('Number', "{$sheetName}!\$C\${$startRowMingguan}:\$C\${$endRowMingguan}", null, $this->dataMingguan->count())];

        $seriesMingguanJumlah = new DataSeries(DataSeries::TYPE_BARCHART, DataSeries::GROUPING_CLUSTERED, range(0, count($valuesMingguanJumlah) - 1), [], $labelsMingguan, $valuesMingguanJumlah, null, 'Jumlah Tanaman Mingguan');
        $seriesMingguanJumlah->setPlotDirection(DataSeries::DIRECTION_COL);

        $plotAreaMingguanJumlah = new PlotArea(null, [$seriesMingguanJumlah]);
        $chartMingguanJumlah = new Chart('chart_mingguan_jumlah', new Title("Jumlah Tanaman $bulanSekarang"), new Legend(Legend::POSITION_RIGHT, null, false), $plotAreaMingguanJumlah);
        $chartMingguanJumlah->setTopLeftPosition('F2');
        $chartMingguanJumlah->setBottomRightPosition('N20');

        // Chart Jumlah Tanaman Tahunan
        $labelsTahunan = [new DataSeriesValues('String', "{$sheetName}!\$A\${$startRowTahunan}:\$A\${$endRowTahunan}", null, $this->dataBulanan->count())];
        $valuesTahunanJumlah = [new DataSeriesValues('Number', "{$sheetName}!\$C\${$startRowTahunan}:\$C\${$endRowTahunan}", null, $this->dataBulanan->count())];

        $seriesTahunanJumlah = new DataSeries(DataSeries::TYPE_BARCHART, DataSeries::GROUPING_CLUSTERED, range(0, count($valuesTahunanJumlah) - 1), [], $labelsTahunan, $valuesTahunanJumlah, null, 'Jumlah Tanaman Tahunan');
        $seriesTahunanJumlah->setPlotDirection(DataSeries::DIRECTION_COL);

        $plotAreaTahunanJumlah = new PlotArea(null, [$seriesTahunanJumlah]);
        $chartTahunanJumlah = new Chart('chart_tahunan_jumlah', new Title("Jumlah Tanaman $tahunSekarang"), new Legend(Legend::POSITION_RIGHT, null, false), $plotAreaTahunanJumlah);
        $chartTahunanJumlah->setTopLeftPosition('P2');
        $chartTahunanJumlah->setBottomRightPosition('X20');

        return [$chartMingguanJumlah, $chartTahunanJumlah];
    }
}
