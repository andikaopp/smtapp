<?php

namespace App\Filament\Resources\AktivitasShifts\Pages;

use App\Filament\Resources\AktivitasShifts\AktivitasShiftResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAktivitasShifts extends ListRecords
{
    protected static string $resource = AktivitasShiftResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
