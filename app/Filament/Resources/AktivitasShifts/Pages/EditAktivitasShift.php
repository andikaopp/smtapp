<?php

namespace App\Filament\Resources\AktivitasShifts\Pages;

use App\Filament\Resources\AktivitasShifts\AktivitasShiftResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAktivitasShift extends EditRecord
{
    protected static string $resource = AktivitasShiftResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
