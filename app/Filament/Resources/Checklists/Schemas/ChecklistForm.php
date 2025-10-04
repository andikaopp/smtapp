<?php

namespace App\Filament\Resources\Checklists\Schemas;

use App\Models\KategoriAktivitasShift;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ChecklistForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('kategori_aktivitas_shift_id')
                    ->options(KategoriAktivitasShift::all()->pluck("kategori", "id"))
                    ->required(),
                Textarea::make('todo')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }
}
