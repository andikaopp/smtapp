<?php

namespace App\Filament\Resources\AktivitasShifts;

use App\Filament\Resources\AktivitasShifts\Pages\CreateAktivitasShift;
use App\Filament\Resources\AktivitasShifts\Pages\EditAktivitasShift;
use App\Filament\Resources\AktivitasShifts\Pages\ListAktivitasShifts;
use App\Filament\Resources\AktivitasShifts\Schemas\AktivitasShiftForm;
use App\Filament\Resources\AktivitasShifts\Tables\AktivitasShiftsTable;
use App\Models\AktivitasShift;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AktivitasShiftResource extends Resource
{
    protected static ?string $model = AktivitasShift::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return AktivitasShiftForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AktivitasShiftsTable::configure($table);
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
            'index' => ListAktivitasShifts::route('/'),
            'create' => CreateAktivitasShift::route('/create'),
            'edit' => EditAktivitasShift::route('/{record}/edit'),
        ];
    }

}
