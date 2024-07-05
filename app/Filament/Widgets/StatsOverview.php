<?php

namespace App\Filament\Widgets;

use App\Models\JadwalJumat;
use App\Models\Keuangan;
use App\Models\Pengurus;
use App\Models\User;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 2;
    protected function getStats(): array
    {

        // Menghitung Total
        $totalPemasukan = Keuangan::where('tipe', 'pemasukan')->sum('jumlah');
        $totalPengeluaran = Keuangan::where('tipe', 'pengeluaran')->sum('jumlah');
        $totalkas = $totalPemasukan - $totalPengeluaran;

        
        return [
            
            Stat::make('Total Kas', 'Rp' . number_format($totalkas))
                ->description('Total Kas saat ini')
                ->descriptionIcon('heroicon-o-currency-dollar')
                ->color('success'),
            Stat::make('Total Pemasukan', 'Rp' . number_format($totalPemasukan))
                ->description('Total pemasukan yang diterima')
                ->descriptionIcon('heroicon-o-arrow-down-circle')
                ->color('success'),
            Stat::make('Total Pengeluaran', 'Rp' . number_format($totalPengeluaran))
                ->description('Total pengeluaran yang dilakukan')
                ->descriptionIcon('heroicon-o-arrow-up-circle')
                ->color('danger'),
        ];
    }
}
