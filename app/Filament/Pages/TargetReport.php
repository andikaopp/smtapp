<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;

class TargetReport extends Page
{
    protected static string|null|\BackedEnum $navigationIcon = 'heroicon-o-presentation-chart-bar';
    protected static string|null|\UnitEnum $navigationGroup = 'Reporting';
    protected static ?string $navigationLabel = 'Target Report';
    protected static ?string $title = 'Target Report';
    protected static ?int $navigationSort = 1;
    protected string $view = 'filament.pages.target-report';
    public ?object $dataTargetPagi = null;
    public ?object $dataTargetSiang = null;
    public ?object $dataActualPagi = null;
    public ?object $dataActualSiang = null;

    /**
     * Lifecycle hook yang berjalan saat halaman dimuat.
     * Tempat terbaik untuk mengambil data dari database.
     */
    public function mount(): void
    {
        $this->dataTargetPagi = \App\Models\TargetShiftPagi::query()->whereDate('created_at',now()->today())->first();
        $this->dataTargetSiang = \App\Models\TargetShiftSiang::query()->whereDate('created_at',now()->today())->first();
        $this->dataActualPagi = DB::table('actual_shift_pagis')->latest()->first();
        $this->dataActualSiang = DB::table('actual_shift_siangs')->latest()->first();
    }

    public static function canAccess(): bool
    {
        return auth()->user()->can('Menu Report');
    }
}
