<?php

namespace App\Filament\Widgets;

use App\Models\Keuangan;
use Filament\Widgets\ChartWidget;

class KeuanganChart extends ChartWidget
{
    protected static ?string $heading = ' Chart Keuangan';

    protected static ?int $sort = 3;

    protected function getData(): array
    {
        // Ambil data pemasukan dan pengeluaran bulanan
        $currentYear = now()->year;
        $pemasukan = Keuangan::where('tipe', 'pemasukan')
            ->whereYear('tanggal', $currentYear)
            ->selectRaw('MONTH(tanggal) as bulan, SUM(jumlah) as total')
            ->groupBy('bulan')
            ->pluck('total', 'bulan');

        $pengeluaran = Keuangan::where('tipe', 'pengeluaran')
            ->whereYear('tanggal', $currentYear)
            ->selectRaw('MONTH(tanggal) as bulan, SUM(jumlah) as total')
            ->groupBy('bulan')
            ->pluck('total', 'bulan');

        $labels = [];
        $pemasukanData = [];
        $pengeluaranData = [];

        for ($i = 1; $i <= 12; $i++) {
            $labels[] = date('F', mktime(0, 0, 0, $i, 1));
            $pemasukanData[] = $pemasukan->get($i, 0);
            $pengeluaranData[] = $pengeluaran->get($i, 0);
        }

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Pemasukan',
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                    'borderColor' => 'rgba(75, 192, 192, 1)',
                    'data' => $pemasukanData,
                ],
                [
                    'label' => 'Pengeluaran',
                    'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                    'borderColor' => 'rgba(255, 99, 132, 1)',
                    'data' => $pengeluaranData,
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
