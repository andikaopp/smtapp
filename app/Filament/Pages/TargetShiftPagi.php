<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TargetShiftPagi extends Page
{
    use InteractsWithForms;
    protected static string|null|\BackedEnum $navigationIcon = 'heroicon-o-rocket-launch';
    protected static string|null|\UnitEnum $navigationGroup = 'Shift Pagi';
    protected static ?string $navigationLabel = 'Target';

    protected static ?string $title = 'Target Pagi';
    protected static ?int $navigationSort = 1;
    protected string $view = 'filament.pages.target-shift-pagi';

    public ?array $data = [];
    public bool $hasSubmittedToday = false;
    public function mount(): void
    {
        $userId = Auth::id();
        $submittedTodayCount = \App\Models\TargetShiftPagi::query()
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
        return auth()->user()->can('Disabled');
    }

    protected function getFormSchema(): array
    {
        if ($this->hasSubmittedToday) {
            return [
                Section::make('Target Shift Pagi')
                    ->icon('heroicon-o-check-circle') // Tambahkan ikon untuk visual
                    ->iconColor('success')
                    ->description('Pengisian Target hanya dapat dilakukan sekali sehari.')
                    ->schema([
                        TextEntry::make('submission_message')
                            ->label('Anda sudah berhasil melakukan submit Target Pagi untuk hari ini (' . now()->translatedFormat('d F Y') . '). Terima kasih!')
                    ])
                    ->aside(false)
                    ->heading('Pengisian Target Pagi Complete')
                    ->collapsed(false)
                    ->columns(1),
            ];
        }

        return [
            Repeater::make('targetShift')
                ->statePath('data.targetShiftPagi')
                ->schema([
                    TextInput::make('omset_global')->numeric(),
                    TextInput::make('tc_global')->numeric(),
                    TextInput::make('omset_retail')->numeric(),
                    TextInput::make('tc_retail')->numeric(),
                    TextInput::make('omset_pesanan')->numeric(),
                    TextInput::make('tc_pesanan')->numeric(),
                    TextInput::make('target_lainnya')->numeric(),
                    TextInput::make('jumlah_target')->numeric(),
                ])
            ->columns(1)
            ->deletable(false)
            ->addable(false)
            ->reorderable(false),
        ];
    }

    public function submit()
    {
        $userId = Auth::id();

        //Validate is had submitted today
        $submittedTodayCount = \App\Models\TargetShiftPagi::query()
            ->where('user_id', $userId)
            ->whereDate('created_at', now()->today())
            ->count();
        if ($submittedTodayCount > 0) {
            Notification::make()
                ->title('Gagal Submit')
                ->body('Anda Telah Melakukan Submit Target Pagi Hari Ini (Lengkap). Submit hanya diperbolehkan sekali per hari.')
                ->danger()
                ->send();
            return; // Menghentikan proses submit
        }
        //---- validate

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

        $targetSubmit = $validatedData['data']['targetShiftPagi'] ?? [];

        if (empty($targetSubmit)) {
            Notification::make()
                ->title('Gagal menyimpan data')
                ->body('Tidak ada data target yang ditemukan.')
                ->danger()
                ->send();
            return;
        }

        DB::beginTransaction();
        try {
            $dataToInsert = [];

            foreach ($targetSubmit as $item) {
                $dataToInsert[] = [
                    'user_id' => Auth::id(),
                    'omset_global' => $item['omset_global'],
                    'tc_global' => $item['tc_global'],
                    'omset_retail' => $item['omset_retail'],
                    'tc_retail' => $item['tc_retail'],
                    'omset_pesanan' => $item['omset_pesanan'],
                    'tc_pesanan' => $item['tc_pesanan'],
                    'target_lainnya' => $item['target_lainnya'],
                    'jumlah_target' => $item['jumlah_target'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            \App\Models\TargetShiftPagi::query()->insert($dataToInsert);

            DB::commit();

            Notification::make()
                ->title('Penyimpanan Berhasil')
                ->body('Target Pagi telah berhasil disimpan.')
                ->success()
                ->send();

            $this->form->fill();

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Target Pagi Save Error: ' . $e->getMessage());
            Notification::make()
                ->title('Penyimpanan Gagal')
                ->body('Terjadi kesalahan saat menyimpan data. Silakan coba lagi.')
                ->danger()
                ->send();
        }
    }
}
