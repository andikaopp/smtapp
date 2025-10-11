<?php

namespace App\Filament\Resources\Karyawans\Schemas;

use App\Models\Cabang;
use App\Models\Karyawan;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class KaryawanForm
{
    public static function configure(Schema $schema): Schema
    {
        $registeredUser = Karyawan::pluck('user_id')->unique();

        return $schema
            ->components([
                TextInput::make('nama')
                    ->required(),
                TextInput::make('alamat'),
                TextInput::make('no_telp')
                    ->tel(),
                Select::make('cabang_id')
                    ->options(Cabang::all()->pluck("nama_cabang", "id"))
                    ->required(),
                Select::make('user_id')
                    ->options(User::query()->whereNotIn('id', $registeredUser)->pluck("name", "id"))
                    ->required(),
            ]);
    }
}
