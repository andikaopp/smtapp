<?php

namespace App\Filament\Resources\Cabangs\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CabangForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama_cabang')
                    ->required(),
                TextInput::make('alamat')
                    ->required(),
                TextInput::make('no_telp')
                    ->tel()
                    ->required(),
            ]);
    }
}
