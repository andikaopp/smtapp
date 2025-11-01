<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Pages\Page;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class TargetReport extends Page
{
    use InteractsWithForms;

    protected static string|null|\BackedEnum $navigationIcon = 'heroicon-o-presentation-chart-bar';
    protected static string|null|\UnitEnum $navigationGroup = 'Reporting';
    protected static ?string $navigationLabel = 'Target Report';
    protected static ?string $title = 'Target Report';
    protected static ?int $navigationSort = 1;
    protected string $view = 'filament.pages.target-report';
    public ?array $data = [];
    public ?array $reportData = null;

    public function mount(): void
    {
        $this->form->fill([
            'selected_date' => now()->format('Y-m-d')
        ]);
    }

    public static function canAccess(): bool
    {
        return auth()->user()->can('Menu Report');
    }

    protected function getFormSchema(): array
    {
        return [
            DatePicker::make('selected_date')
                ->label('Tanggal Laporan')
                ->required(),
        ];
    }

    protected function getFormStatePath(): string
    {
        return 'data';
    }

    public function loadReport(): void
    {
        $formData = $this->form->getState();
        $selectedDate = Carbon::parse($formData['selected_date']);
        $query = DB::table('aktivitas_shifts')
            ->join('users', 'aktivitas_shifts.user_id', '=', 'users.id')
            ->join('shifts', 'aktivitas_shifts.shift_id', '=', 'shifts.id')
            ->join('checklists', 'aktivitas_shifts.checklist_id', '=', 'checklists.id')
            ->join('kategori_aktivitas_shifts', 'checklists.kategori_aktivitas_shift_id', '=', 'kategori_aktivitas_shifts.id')

            // --- FILTER DINAMIS ---
            // Mengganti curdate() dengan data dari filter form
            ->whereDate('aktivitas_shifts.created_at', $selectedDate);

            // --- FILTER HARDCODED (Sesuai query Anda) ---
//            ->where('kategori_aktivitas_shifts.id', 5);

        // 3. Ambil kolom (select) yang kita butuhkan
        $results = $query->select(
        // Data untuk header
            'users.name as completed_by',
            'shifts.id as shift_id',
            'shifts.name as shift_name',

            // Data untuk mapping tabel
            'checklists.todo',
            'aktivitas_shifts.comment',
            'aktivitas_shifts.is_checklist_id_checked',
            'kategori_aktivitas_shifts.id as kategori_aktivitas_shift_id',
        )->get();


        // 4. Handle jika data tidak ditemukan
        if ($results->isEmpty()) {
            // Tampilkan notifikasi
            \Filament\Notifications\Notification::make()
                ->title('Data tidak ditemukan')
                ->body('Tidak ada data laporan untuk tanggal dan kriteria yang dipilih.')
                ->warning()
                ->send();

            // Kosongkan reportData agar view kembali ke "Belum Ada Laporan"
            $this->reportData = null;
            return;
        }

        // 5. Lakukan MAPPING sesuai permintaan Anda
        $activities = $results->map(function ($item) {
            return [
                // 'name' di view (kiri) => 'checklists.todo' dari query (kanan)
                'name' => $item->todo,

                // 'comment' di view (kiri) => 'comment' dari query (kanan)
                'comment' => $item->comment,

                // 'status' di view (kiri) => 'is_checklist_id_checked' dari query (kanan)
                // Kita ubah boolean (1/0) menjadi string "Ya" / "Tidak"
                'status' => $item->is_checklist_id_checked ? 'Ya' : 'Tidak',
                'karyawan' => $item->completed_by,
                'kategori_aktivitas_shift_id' => $item->kategori_aktivitas_shift_id,
                'shift_id' => $item->shift_id,
            ];
        });

        // 6. Ambil data header dari baris pertama (karena semuanya sama)
        $firstResult = $results->first();

        // (Data dummy untuk contoh)
        $dummyActivities = [
            [
                'name' => 'Pintu dan area kaca depan bersih tanpa bekas sidik jari',
                'comment' => 'Buat shift terakhir harap selalu membersihkan juga yaa',
                'status' => 'Ya'
            ],
            [
                'name' => 'Lantai area lobby sudah dipel dan wangi',
                'comment' => 'Stok pewangi lantai menipis',
                'status' => 'Ya'
            ],
            [
                'name' => 'Kamar mandi bersih dan tidak berbau',
                'comment' => 'Perlu pengecekan berkala',
                'status' => 'Tidak'
            ],
        ];

        // Set properti $reportData.
        // Blade akan otomatis mendeteksi perubahan ini dan menampilkan laporannya.
        $this->reportData = [
            'completed_by' => 'Admin', // Ganti dengan data dinamis jika perlu
            'date' => $selectedDate->format('d F Y'),
            'activities' => $activities, // Hasil query Anda
        ];
    }
}
