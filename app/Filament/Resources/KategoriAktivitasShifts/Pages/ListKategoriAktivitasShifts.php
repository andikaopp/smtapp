<?php

namespace App\Filament\Resources\KategoriAktivitasShifts\Pages;

use App\Filament\Resources\KategoriAktivitasShifts\KategoriAktivitasShiftResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListKategoriAktivitasShifts extends ListRecords
{
    protected static string $resource = KategoriAktivitasShiftResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
