<?php

namespace App\Filament\Resources\AktivitasShifts\Pages;

use App\Filament\Resources\AktivitasShifts\AktivitasShiftResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAktivitasShift extends CreateRecord
{
    protected static string $resource = AktivitasShiftResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        return $data;
    }
}
