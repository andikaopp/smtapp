<?php

namespace App\Filament\Resources\TargetShiftSiangs;

use App\Filament\Resources\TargetShiftSiangs\Pages\CreateTargetShiftSiang;
use App\Filament\Resources\TargetShiftSiangs\Pages\EditTargetShiftSiang;
use App\Filament\Resources\TargetShiftSiangs\Pages\ListTargetShiftSiangs;
use App\Filament\Resources\TargetShiftSiangs\Schemas\TargetShiftSiangForm;
use App\Filament\Resources\TargetShiftSiangs\Tables\TargetShiftSiangsTable;
use App\Models\TargetShiftSiang;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TargetShiftSiangResource extends Resource
{
    protected static ?string $model = TargetShiftSiang::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return TargetShiftSiangForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TargetShiftSiangsTable::configure($table);
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
            'index' => ListTargetShiftSiangs::route('/'),
            'create' => CreateTargetShiftSiang::route('/create'),
            'edit' => EditTargetShiftSiang::route('/{record}/edit'),
        ];
    }
}
