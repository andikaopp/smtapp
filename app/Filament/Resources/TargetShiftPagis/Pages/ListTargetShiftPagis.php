<?php

namespace App\Filament\Resources\TargetShiftPagis\Pages;

use App\Filament\Resources\TargetShiftPagis\TargetShiftPagiResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTargetShiftPagis extends ListRecords
{
    protected static string $resource = TargetShiftPagiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
