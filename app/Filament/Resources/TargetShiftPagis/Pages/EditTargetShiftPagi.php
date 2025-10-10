<?php

namespace App\Filament\Resources\TargetShiftPagis\Pages;

use App\Filament\Resources\TargetShiftPagis\TargetShiftPagiResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTargetShiftPagi extends EditRecord
{
    protected static string $resource = TargetShiftPagiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
