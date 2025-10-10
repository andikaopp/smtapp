<?php

namespace App\Filament\Resources\TargetShiftSiangs\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TargetShiftSiangForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                TextInput::make('omset_retail')
                    ->numeric(),
                TextInput::make('tc_retail')
                    ->numeric(),
                TextInput::make('omset_pesanan')
                    ->numeric(),
                TextInput::make('tc_pesanan')
                    ->numeric(),
                TextInput::make('target_lainnya')
                    ->numeric(),
                TextInput::make('jumlah_target')
                    ->numeric(),
            ]);
    }
}
