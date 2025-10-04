<?php

namespace App\Filament\Resources\KategoriAktivitasShifts;

use App\Filament\Resources\KategoriAktivitasShifts\Pages\CreateKategoriAktivitasShift;
use App\Filament\Resources\KategoriAktivitasShifts\Pages\EditKategoriAktivitasShift;
use App\Filament\Resources\KategoriAktivitasShifts\Pages\ListKategoriAktivitasShifts;
use App\Filament\Resources\KategoriAktivitasShifts\Schemas\KategoriAktivitasShiftForm;
use App\Filament\Resources\KategoriAktivitasShifts\Tables\KategoriAktivitasShiftsTable;
use App\Models\KategoriAktivitasShift;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class KategoriAktivitasShiftResource extends Resource
{
    protected static ?string $model = KategoriAktivitasShift::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return KategoriAktivitasShiftForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KategoriAktivitasShiftsTable::configure($table);
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
            'index' => ListKategoriAktivitasShifts::route('/'),
            'create' => CreateKategoriAktivitasShift::route('/create'),
            'edit' => EditKategoriAktivitasShift::route('/{record}/edit'),
        ];
    }
}
