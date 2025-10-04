<?php

namespace App\Filament\Resources\KategoriAktivitasShifts\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class KategoriAktivitasShiftForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('kategori')
                    ->required(),
            ]);
    }
}
