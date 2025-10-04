<?php

namespace App\Filament\Resources\Cabangs;

use App\Filament\Resources\Cabangs\Pages\CreateCabang;
use App\Filament\Resources\Cabangs\Pages\EditCabang;
use App\Filament\Resources\Cabangs\Pages\ListCabangs;
use App\Filament\Resources\Cabangs\Schemas\CabangForm;
use App\Filament\Resources\Cabangs\Tables\CabangsTable;
use App\Models\Cabang;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CabangResource extends Resource
{
    protected static ?string $model = Cabang::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return CabangForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CabangsTable::configure($table);
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
            'index' => ListCabangs::route('/'),
            'create' => CreateCabang::route('/create'),
            'edit' => EditCabang::route('/{record}/edit'),
        ];
    }
}
