<?php

namespace App\Filament\Resources\TargetShiftPagis\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TargetShiftPagisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->searchable(),
                TextColumn::make('omset_global')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('tc_global')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('omset_retail')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('tc_retail')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('omset_pesanan')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('tc_pesanan')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('target_lainnya')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('jumlah_target')
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
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
