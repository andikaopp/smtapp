<?php

namespace App\Filament\Resources\TargetShiftSiangs\Pages;

use App\Filament\Resources\TargetShiftSiangs\TargetShiftSiangResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTargetShiftSiangs extends ListRecords
{
    protected static string $resource = TargetShiftSiangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
