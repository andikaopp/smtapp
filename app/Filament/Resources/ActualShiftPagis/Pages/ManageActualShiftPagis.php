<?php

namespace App\Filament\Resources\ActualShiftPagis\Pages;

use App\Filament\Resources\ActualShiftPagis\ActualShiftPagiResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageActualShiftPagis extends ManageRecords
{
    protected static string $resource = ActualShiftPagiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
