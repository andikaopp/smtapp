<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ActualShiftPagi extends Page
{
    use InteractsWithForms;
    protected static string|null|\BackedEnum $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static string|null|\UnitEnum $navigationGroup = 'Shift Pagi';
    protected static ?string $navigationLabel = 'Actual Result';

    protected static ?string $title = 'Actual Result Pagi';
    protected static ?int $navigationSort = 5;
    protected string $view = 'filament.pages.actual-shift-pagi';

    public ?array $data = [];
    public bool $hasSubmittedToday = false;
    public function mount(): void
    {
        $userId = Auth::id();
        $submittedTodayCount = \App\Models\ActualShiftPagi::query()
            ->where('user_id', $userId)
            ->whereDate('created_at', now()->today())
            ->count();

        $this->hasSubmittedToday = $submittedTodayCount > 0;

        if (!$this->hasSubmittedToday) {
            $this->form->fill();
        }
    }

    public static function canAccess(): bool
    {
        return auth()->user()->can('Menu Shift Pagi');
    }

    protected function getFormSchema(): array
    {
        if ($this->hasSubmittedToday) {
            return [
                Section::make('Actual Shift Pagi')
                    ->icon('heroicon-o-check-circle')
                    ->iconColor('success')
                    ->description('Pengisian Actual Result hanya dapat dilakukan sekali sehari.')
                    ->schema([
                        TextEntry::make('submission_message')
                            ->label('Submit Actual Result Pagi untuk hari ini (' . now()->translatedFormat('d F Y') . ')Telah Dilakukan. Terima kasih!')
                    ])
                    ->aside(false)
                    ->heading('Pengisian Actual Result Pagi Complete')
                    ->collapsed(false)
                    ->columns(1),
            ];
        }

        return [
            Grid::make(1)
                ->schema([
                    Section::make('Details')
                        ->schema([
                            TextInput::make('actual_omset_retail')->numeric()->required(),
                            TextInput::make('actual_tc_retail')->numeric()->required(),
                            TextInput::make('actual_omset_pesanan')->numeric()->required(),
                            TextInput::make('actual_tc_pesanan')->numeric()->required(),
                            TextInput::make('actual_target_lainnya')->numeric()->required(),
                        ])
                ])->statePath('data')
        ];
    }

    public function submit(): void
    {
        $userId = Auth::id();
        $submittedTodayCount = \App\Models\ActualShiftPagi::query()
            ->where('user_id', $userId)
            ->whereDate('created_at', now()->today())
            ->count();
        if ($submittedTodayCount > 0) {
            Notification::make()
                ->title('Gagal Submit')
                ->body('Anda Telah Melakukan Submit Actual Result Pagi Hari Ini. Submit hanya diperbolehkan sekali per hari.')
                ->danger()
                ->send();
            return;
        }

        try {
            $validatedData = $this->form->getState();
        } catch (\Exception $e) {
            Notification::make()
                ->title('Gagal menyimpan data')
                ->body('Terdapat kesalahan pada input Anda.')
                ->danger()
                ->send();
            return;
        }

        $targetSubmit = $validatedData['data'] ?? [];

        if (empty($targetSubmit)) {
            Notification::make()
                ->title('Gagal menyimpan data')
                ->body('Tidak ada data actual result yang ditemukan.')
                ->danger()
                ->send();
            return;
        }

        DB::beginTransaction();
        try {
            $dataToInsert[] = [
                'user_id' => Auth::id(),
                'actual_omset_retail' => $targetSubmit['actual_omset_retail'],
                'actual_tc_retail' => $targetSubmit['actual_tc_retail'],
                'actual_omset_pesanan' => $targetSubmit['actual_omset_pesanan'],
                'actual_tc_pesanan' => $targetSubmit['actual_tc_pesanan'],
                'actual_target_lainnya' => $targetSubmit['actual_target_lainnya'],
                'created_at' => now(),
                'updated_at' => now(),
            ];

            \App\Models\ActualShiftPagi::query()->insert($dataToInsert);

            DB::commit();

            Notification::make()
                ->title('Penyimpanan Berhasil')
                ->body('Actual Result Pagi telah berhasil disimpan.')
                ->success()
                ->send();

            $this->form->fill();

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Actual Result Pagi Save Error: ' . $e->getMessage());
            Notification::make()
                ->title('Penyimpanan Gagal')
                ->body('Terjadi kesalahan saat menyimpan data. Silakan coba lagi.')
                ->danger()
                ->send();
        }
    }
}
