<?php

namespace App\Filament\Resources\KategoriAktivitasShifts\Pages;

use App\Filament\Resources\KategoriAktivitasShifts\KategoriAktivitasShiftResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditKategoriAktivitasShift extends EditRecord
{
    protected static string $resource = KategoriAktivitasShiftResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
