<?php

namespace App\Filament\Resources\AktivitasShifts\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class AktivitasShiftForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('shift_id')
                    ->relationship('shift', 'name')
                    ->required(),
                Select::make('checklist_id')
                    ->relationship('checklist', 'todo')
                    ->required(),
                Toggle::make('is_checklist_id_checked')
                    ->required(),
                TextInput::make('photo'),
                Textarea::make('comment')
                    ->columnSpanFull(),
            ]);
    }
}
