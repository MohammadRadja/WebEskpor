<?php

namespace App\Exports;

use App\Models\Bibit;
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

class BibitExport implements FromCollection, WithHeadings, WithCharts, WithEvents
{
    protected $dataMingguan;
    protected $dataBulanan;

    public function __construct()
    {
        // --- Data Mingguan ---
        $rawMingguan = Bibit::whereNotNull('tanggal_pembelian')
            ->where('tanggal_pembelian', '>=', now()->subDays(30)) // contoh: 30 hari terakhir
            ->select(DB::raw('DATE(tanggal_pembelian) as tanggal'), DB::raw('SUM(jumlah) as total_jumlah'), DB::raw('SUM(harga_satuan * jumlah) as total_harga'))
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
                    'total_jumlah' => 0,
                    'total_harga' => 0,
                ];
            }
            $groupMingguan[$key]['total_jumlah'] += $item->total_jumlah;
            $groupMingguan[$key]['total_harga'] += $item->total_harga;
        }

        $this->dataMingguan = collect([]);
        foreach ($groupMingguan as $periode => $totals) {
            $this->dataMingguan->push(
                (object) [
                    'periode' => $periode,
                    'total_jumlah' => $totals['total_jumlah'],
                    'total_harga' => $totals['total_harga'],
                ],
            );
        }

        // --- Data Bulanan ---
        $rawBulanan = Bibit::whereNotNull('tanggal_pembelian')
            ->where('tanggal_pembelian', '>=', now()->subMonths(12))
            ->select(DB::raw('DATE_FORMAT(tanggal_pembelian, "%Y-%m") as periode'), DB::raw('SUM(jumlah) as total_jumlah'), DB::raw('SUM(harga_satuan * jumlah) as total_harga'))
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
                    'total_jumlah' => $item->total_jumlah,
                    'total_harga' => $item->total_harga,
                ],
            );
        }
    }

    public function collection()
    {
        $rows = [];

        // Judul & Periode
        $rows[] = ['Laporan Pembelian Bibit'];
        $rows[] = ['Periode: ' . now()->subMonths(12)->format('d M Y') . ' - ' . now()->format('d M Y')];
        $rows[] = [];

        // Header Mingguan
        $rows[] = $this->headings();

        // Data Mingguan
        foreach ($this->dataMingguan as $item) {
            $rows[] = [$item->periode, $item->total_jumlah, $item->total_harga, 'Mingguan'];
        }

        // Total Mingguan
        $rows[] = ['Total Mingguan', $this->dataMingguan->sum('total_jumlah'), $this->dataMingguan->sum('total_harga'), ''];

        $rows[] = [];

        // Header Bulanan
        $rows[] = $this->headings();

        // Data Bulanan
        foreach ($this->dataBulanan as $item) {
            $rows[] = [$item->periode, $item->total_jumlah, $item->total_harga, 'Bulanan'];
        }

        // Total Bulanan
        $rows[] = ['Total Bulanan', $this->dataBulanan->sum('total_jumlah'), $this->dataBulanan->sum('total_harga'), ''];

        return collect($rows);
    }

    public function headings(): array
    {
        return ['Periode', 'Total Jumlah Bibit', 'Total Pembelian (Rp)', 'Keterangan'];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Styling judul dan periode (sama seperti sebelumnya)
                $sheet->mergeCells('A1:D1');
                $sheet->setCellValue('A1', 'Laporan Pembelian Bibit PT. Rajawali Prima Andalas');
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

        // Baris awal data mingguan & bulanan
        $startRowMingguan = 5;
        $endRowMingguan = $startRowMingguan + $this->dataMingguan->count() - 1;

        $startRowBulanan = $endRowMingguan + 4; // 1 total mingguan + 2 kosong + header bulanan
        $endRowBulanan = $startRowBulanan + $this->dataBulanan->count() - 1;

        // Chart untuk jumlah bibit Mingguan
        $labelsMingguan = [new DataSeriesValues('String', "{$sheetName}!\$A\${$startRowMingguan}:\$A\${$endRowMingguan}", null, $this->dataMingguan->count())];
        $valuesMingguanJumlah = [new DataSeriesValues('Number', "{$sheetName}!\$B\${$startRowMingguan}:\$B\${$endRowMingguan}", null, $this->dataMingguan->count())];

        $seriesMingguanJumlah = new DataSeries(DataSeries::TYPE_BARCHART, DataSeries::GROUPING_CLUSTERED, range(0, count($valuesMingguanJumlah) - 1), [], $labelsMingguan, $valuesMingguanJumlah, null, 'Jumlah Bibit Mingguan');
        $seriesMingguanJumlah->setPlotDirection(DataSeries::DIRECTION_COL);

        $plotAreaMingguanJumlah = new PlotArea(null, [$seriesMingguanJumlah]);
        $chartMingguanJumlah = new Chart('chart_mingguan_jumlah', new Title("Grafik Jumlah Bibit $bulanSekarang"), new Legend(Legend::POSITION_RIGHT, null, false), $plotAreaMingguanJumlah);
        $chartMingguanJumlah->setTopLeftPosition('F2');
        $chartMingguanJumlah->setBottomRightPosition('N20');

        // Chart untuk total harga Mingguan
        $valuesMingguanHarga = [new DataSeriesValues('Number', "{$sheetName}!\$C\${$startRowMingguan}:\$C\${$endRowMingguan}", null, $this->dataMingguan->count())];

        $seriesMingguanHarga = new DataSeries(DataSeries::TYPE_BARCHART, DataSeries::GROUPING_CLUSTERED, range(0, count($valuesMingguanHarga) - 1), [], $labelsMingguan, $valuesMingguanHarga, null, 'Total Pembelian Bibit Mingguan');
        $seriesMingguanHarga->setPlotDirection(DataSeries::DIRECTION_COL);

        $plotAreaMingguanHarga = new PlotArea(null, [$seriesMingguanHarga]);
        $chartMingguanHarga = new Chart('chart_mingguan_harga', new Title("Grafik Total Pembelian Bibit $bulanSekarang"), new Legend(Legend::POSITION_RIGHT, null, false), $plotAreaMingguanHarga);
        $chartMingguanHarga->setTopLeftPosition('F22');
        $chartMingguanHarga->setBottomRightPosition('N40');

        // Chart untuk jumlah bibit Bulanan
        $labelsBulanan = [new DataSeriesValues('String', "{$sheetName}!\$A\${$startRowBulanan}:\$A\${$endRowBulanan}", null, $this->dataBulanan->count())];
        $valuesBulananJumlah = [new DataSeriesValues('Number', "{$sheetName}!\$B\${$startRowBulanan}:\$B\${$endRowBulanan}", null, $this->dataBulanan->count())];

        $seriesBulananJumlah = new DataSeries(DataSeries::TYPE_BARCHART, DataSeries::GROUPING_CLUSTERED, range(0, count($valuesBulananJumlah) - 1), [], $labelsBulanan, $valuesBulananJumlah, null, 'Jumlah Bibit Bulanan');
        $seriesBulananJumlah->setPlotDirection(DataSeries::DIRECTION_COL);

        $plotAreaBulananJumlah = new PlotArea(null, [$seriesBulananJumlah]);
        $chartBulananJumlah = new Chart('chart_bulanan_jumlah', new Title("Grafik Jumlah Bibit $tahunSekarang"), new Legend(Legend::POSITION_RIGHT, null, false), $plotAreaBulananJumlah);
        $chartBulananJumlah->setTopLeftPosition('P2');
        $chartBulananJumlah->setBottomRightPosition('X20');

        // Chart untuk total harga Bulanan
        $valuesBulananHarga = [new DataSeriesValues('Number', "{$sheetName}!\$C\${$startRowBulanan}:\$C\${$endRowBulanan}", null, $this->dataBulanan->count())];

        $seriesBulananHarga = new DataSeries(DataSeries::TYPE_BARCHART, DataSeries::GROUPING_CLUSTERED, range(0, count($valuesBulananHarga) - 1), [], $labelsBulanan, $valuesBulananHarga, null, 'Total Pembelian Bibit Bulanan');
        $seriesBulananHarga->setPlotDirection(DataSeries::DIRECTION_COL);

        $plotAreaBulananHarga = new PlotArea(null, [$seriesBulananHarga]);
        $chartBulananHarga = new Chart('chart_bulanan_harga', new Title("Grafik Total Pembelian Bibit $tahunSekarang"), new Legend(Legend::POSITION_RIGHT, null, false), $plotAreaBulananHarga);
        $chartBulananHarga->setTopLeftPosition('P22');
        $chartBulananHarga->setBottomRightPosition('X40');

        // Return semua chart
        return [$chartMingguanJumlah, $chartMingguanHarga, $chartBulananJumlah, $chartBulananHarga];
    }
}
