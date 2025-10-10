<?php

namespace App\Filament\Resources\TargetShiftPagis;

use App\Filament\Resources\TargetShiftPagis\Pages\CreateTargetShiftPagi;
use App\Filament\Resources\TargetShiftPagis\Pages\EditTargetShiftPagi;
use App\Filament\Resources\TargetShiftPagis\Pages\ListTargetShiftPagis;
use App\Filament\Resources\TargetShiftPagis\Schemas\TargetShiftPagiForm;
use App\Filament\Resources\TargetShiftPagis\Tables\TargetShiftPagisTable;
use App\Models\TargetShiftPagi;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TargetShiftPagiResource extends Resource
{
    protected static ?string $model = TargetShiftPagi::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return TargetShiftPagiForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TargetShiftPagisTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTargetShiftPagis::route('/'),
            'create' => CreateTargetShiftPagi::route('/create'),
            'edit' => EditTargetShiftPagi::route('/{record}/edit'),
        ];
    }
}
