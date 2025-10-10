<?php

namespace App\Filament\Resources\TargetShiftSiangs\Pages;

use App\Filament\Resources\TargetShiftSiangs\TargetShiftSiangResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTargetShiftSiang extends EditRecord
{
    protected static string $resource = TargetShiftSiangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
