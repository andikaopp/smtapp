<?php

namespace App\Filament\Resources\ActualShiftSiangs\Pages;

use App\Filament\Resources\ActualShiftSiangs\ActualShiftSiangResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageActualShiftSiangs extends ManageRecords
{
    protected static string $resource = ActualShiftSiangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
