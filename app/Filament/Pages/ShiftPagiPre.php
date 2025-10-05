<?php

namespace App\Filament\Pages;

use App\Models\AktivitasShift;
use App\Models\Checklist;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ShiftPagiPre extends Page
{
    use InteractsWithForms;

    protected static string|null|\BackedEnum $navigationIcon = 'heroicon-o-sun';
    protected static ?string $title = 'Shift Pagi - Pre Shift';
    protected static ?string $navigationLabel = 'Shift Pagi Pre';
    protected static string|null|\UnitEnum $navigationGroup = 'Shift Pagi';
    protected static ?int $navigationSort = 1;
    protected string $view = 'filament.pages.shift-pagi-pre';

    public ?array $data = [];
    public bool $hasSubmittedToday = false;
    public function mount(): void
    {
        $userId = Auth::id();
        $kategoriId = 1; // ID Kategori untuk Pre-Shift (sesuai getFormSchema)

        // 1. Hitung total checklist yang harus diisi
        $requiredChecklistCount = Checklist::where('kategori_aktivitas_shift_id', $kategoriId)->count();

        // 2. Hitung jumlah checklist yang sudah diisi user hari ini,
        //    dengan JOIN ke tabel `checklists` untuk memfilter berdasarkan kategori.
        $submittedChecklistCount = AktivitasShift::query()
            ->where('aktivitas_shifts.user_id', $userId)
            ->whereDate('aktivitas_shifts.created_at', now()->today())
            ->where('aktivitas_shifts.shift_id', 1) // Sesuaikan dengan shift_id yang Anda gunakan
            ->join('checklists', 'aktivitas_shifts.checklist_id', '=', 'checklists.id')
            ->where('checklists.kategori_aktivitas_shift_id', $kategoriId)
            ->count();

        // 3. Cek apakah jumlah yang diisi sudah sama dengan yang diperlukan
        $this->hasSubmittedToday = ($submittedChecklistCount > 0) && ($submittedChecklistCount === $requiredChecklistCount);

        // Isi form hanya jika belum submit
        if (!$this->hasSubmittedToday) {
            $this->form->fill();
        }
    }

    protected function getFormSchema(): array
    {
        if ($this->hasSubmittedToday) {
            return [
                Section::make('Status Checklist Harian')
                    ->icon('heroicon-o-check-circle') // Tambahkan ikon untuk visual
                    ->iconColor('success')
                    ->description('Pengecekan ini hanya dapat dilakukan sekali sehari.')
                    ->schema([
                        TextEntry::make('submission_message')
                            ->label('Anda sudah berhasil melakukan submit Checklist Pre Shift Pagi untuk hari ini (' . now()->translatedFormat('d F Y') . '). Terima kasih!')
                    ])
                    ->aside(false)
                    ->heading('Pengisian Checklist Complete')
                    ->collapsed(false)
                    ->columns(1),
            ];
        }

        return [
            Repeater::make('checklists')
                ->label('Silahkan Cheklist Data Di bawah ini')
                ->statePath('data.checklists')
                ->schema([
                    Toggle::make('is_checklist_id_checked')
                        ->label(fn (Get $get) => $get('todo') ?? 'Checklist'),
                    TextInput::make('comment')->label('Keterangan'),
                ])
                ->columns(2)
                ->default(
                    Checklist::query()->where('kategori_aktivitas_shift_id', 1)
                        ->get(['id', 'todo'])
                        ->map(fn ($item) => [
                            'todo' => $item->todo,
                            'checklist_id' => $item->id,
                            'user_id' => Auth::id(),
                            'shift_id' => 2
                        ])
                        ->toArray()
                )
                ->deletable(false)
                ->addable(false)
                ->reorderable(false),
        ];
    }

    public function submit()
    {
        $userId = Auth::id();
        $kategoriId = 1; // ID Kategori untuk Pre-Shift

        // --- VALIDASI KELENGKAPAN SUBMIT (diulang dari mount untuk keamanan) ---
        $requiredChecklistCount = Checklist::where('kategori_aktivitas_shift_id', $kategoriId)->count();
        $submittedChecklistCount = AktivitasShift::query()
            ->where('aktivitas_shifts.user_id', $userId)
            ->whereDate('aktivitas_shifts.created_at', now()->today())
            ->where('aktivitas_shifts.shift_id', 1)
            ->join('checklists', 'aktivitas_shifts.checklist_id', '=', 'checklists.id')
            ->where('checklists.kategori_aktivitas_shift_id', $kategoriId)
            ->count();

        // Cek jika sudah submit dan jumlahnya sesuai (atau sudah ada lebih dari 0)
        if ($submittedChecklistCount > 0 && $submittedChecklistCount === $requiredChecklistCount) {
            Notification::make()
                ->title('Gagal Submit')
                ->body('Anda Telah Melakukan Submit Shift Pagi Hari Ini (Lengkap). Submit hanya diperbolehkan sekali per hari.')
                ->danger()
                ->send();
            return; // Menghentikan proses submit
        }
        // ---------------------------------------------

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

        $checklists = $validatedData['data']['checklists'] ?? [];

        if (empty($checklists)) {
            Notification::make()
                ->title('Gagal menyimpan data')
                ->body('Tidak ada item checklist yang ditemukan.')
                ->danger()
                ->send();
            return;
        }

        DB::beginTransaction();
        try {
            $dataToInsert = [];

            foreach ($checklists as $item) {
                $dataToInsert[] = [
                    'user_id' => Auth::id(),
                    'checklist_id' => $item['checklist_id'],
                    'shift_id' => 1,
                    'comment' => $item['comment'] ?? null,
                    'is_checklist_id_checked' => $item['is_checklist_id_checked'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            AktivitasShift::insert($dataToInsert);

            DB::commit();

            Notification::make()
                ->title('Penyimpanan Berhasil')
                ->body('Checklist shift pagi telah berhasil disimpan.')
                ->success()
                ->send();

            // 4. Opsional: Redirect atau Reset Form
            // Redirect ke halaman lain setelah selesai, atau tetap di halaman ini.
            // return redirect()->to(ShiftPagiDuring::getUrl());

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Aktivitas Shift Save Error: ' . $e->getMessage());
            Notification::make()
                ->title('Penyimpanan Gagal')
                ->body('Terjadi kesalahan saat menyimpan data. Silakan coba lagi.')
                ->danger()
                ->send();
        }
    }
}
