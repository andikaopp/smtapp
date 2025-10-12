<?php

namespace App\Filament\Resources\ActualShiftPagis;

use App\Filament\Resources\ActualShiftPagis\Pages\ManageActualShiftPagis;
use App\Models\ActualShiftPagi;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ActualShiftPagiResource extends Resource
{
    protected static ?string $model = ActualShiftPagi::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                TextInput::make('actual_omset_retail')
                    ->numeric(),
                TextInput::make('actual_tc_retail')
                    ->numeric(),
                TextInput::make('actual_omset_pesanan')
                    ->numeric(),
                TextInput::make('actual_tc_pesanan')
                    ->numeric(),
                TextInput::make('actual_target_lainnya')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('user.name')
                    ->searchable(),
                TextColumn::make('actual_omset_retail')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('actual_tc_retail')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('actual_omset_pesanan')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('actual_tc_pesanan')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('actual_target_lainnya')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageActualShiftPagis::route('/'),
        ];
    }
}
