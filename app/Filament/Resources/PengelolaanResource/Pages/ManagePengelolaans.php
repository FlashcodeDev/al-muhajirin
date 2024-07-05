<?php

namespace App\Filament\Resources\PengelolaanResource\Pages;

use App\Filament\Resources\PengelolaanResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePengelolaans extends ManageRecords
{
    protected static string $resource = PengelolaanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
