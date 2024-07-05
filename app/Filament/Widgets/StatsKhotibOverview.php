<?php

namespace App\Filament\Widgets;

use App\Models\JadwalJumat;
use Illuminate\Support\Carbon;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsKhotibOverview extends BaseWidget
{
    
    protected function getStats(): array
    {
        $today = Carbon::today()->toDateString();
        $jadwalJumat = JadwalJumat::where('tanggal', $today)->first();
        $namaKhotib = $jadwalJumat ? $jadwalJumat->nama_khotib : 'Imam Masjid Al-Muhajirin';
        
        return [
            Stat::make('Khotib atau Imam Hari Ini', $namaKhotib)
                ->description('Tanggal : ' . $today)
                ->descriptionIcon('heroicon-s-calendar'),
        ];
    }
}
