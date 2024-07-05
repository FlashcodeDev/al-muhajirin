<?php

namespace App\Filament\Exports;

use App\Models\Keuangan;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class KeuanganExporter extends Exporter
{
    protected static ?string $model = Keuangan::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('tanggal'),
            ExportColumn::make('tipe'),
            ExportColumn::make('jumlah'),
            ExportColumn::make('plain_deskripsi')
                ->label('Deskripsi'),
            ExportColumn::make('kategori_id')
                ->label('Kategori'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your keuangan export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
