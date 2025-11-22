<?php

namespace App\Filament\Pages;

use App\Models\Cabang;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Pages\Page;
use Filament\Schemas\Components\Grid;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
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

    // Ubah reportData menjadi array list (bukan null by default, tapi array kosong)
    public ?array $reportData = [];

    public function mount(): void
    {
        // Default: Tanggal 1 bulan ini sampai hari ini
        $this->form->fill([
            'start_date' => now()->startOfMonth()->format('Y-m-d'),
            'end_date'   => now()->format('Y-m-d'),
        ]);
    }

    public static function canAccess(): bool
    {
        return auth()->user()->can('Menu Report');
    }

    protected function getFormSchema(): array
    {
        return [
            Grid::make(3) // Menggunakan Grid agar rapi 3 kolom
            ->schema([
                DatePicker::make('start_date')
                    ->label('Tanggal Mulai')
                    ->required()
                    ->maxDate(now()),
                DatePicker::make('end_date')
                    ->label('Tanggal Selesai')
                    ->required()
                    ->maxDate(now()),
                Select::make('cabang_id')
                    ->label('Pilih Cabang')
                    ->options(
                        Cabang::orderBy('nama_cabang')->pluck('nama_cabang', 'id')
                    )
                    ->searchable()
                    ->required(),
            ]),
        ];
    }

    protected function getFormStatePath(): string
    {
        return 'data';
    }

    public function loadReport(): void
    {
        $formData = $this->form->getState();
        $startDate = Carbon::parse($formData['start_date']);
        $endDate = Carbon::parse($formData['end_date']);

        $query = DB::table('aktivitas_shifts')
            ->join('users', 'aktivitas_shifts.user_id', '=', 'users.id')
            ->join('karyawans', 'users.id', '=', 'karyawans.user_id')
            ->join('cabangs', 'karyawans.cabang_id', '=', 'cabangs.id')
            ->join('shifts', 'aktivitas_shifts.shift_id', '=', 'shifts.id')
            ->join('checklists', 'aktivitas_shifts.checklist_id', '=', 'checklists.id')
            ->join('kategori_aktivitas_shifts', 'checklists.kategori_aktivitas_shift_id', '=', 'kategori_aktivitas_shifts.id')
            ->where('cabangs.id', $formData['cabang_id'])

            // --- FILTER DINAMIS RANGE TANGGAL ---
            ->whereDate('aktivitas_shifts.created_at', '>=', $startDate)
            ->whereDate('aktivitas_shifts.created_at', '<=', $endDate)

            // Urutkan berdasarkan tanggal aktivitas
            ->orderBy('aktivitas_shifts.created_at', 'asc');

        // 3. Ambil kolom (select)
        // PENTING: Tambahkan aktivitas_shifts.created_at untuk grouping tanggal
        $results = $query->select(
            'users.name as completed_by',
            'shifts.id as shift_id',
            'shifts.name as shift_name',
            'checklists.todo',
            'aktivitas_shifts.comment',
            'aktivitas_shifts.photo',
            'aktivitas_shifts.is_checklist_id_checked',
            'aktivitas_shifts.created_at as activity_date', // Alias untuk tanggal
            'kategori_aktivitas_shifts.id as kategori_aktivitas_shift_id',
        )->get();

        // 4. Handle jika data tidak ditemukan
        if ($results->isEmpty()) {
            \Filament\Notifications\Notification::make()
                ->title('Data tidak ditemukan')
                ->body('Tidak ada data laporan untuk rentang tanggal dan kriteria yang dipilih.')
                ->warning()
                ->send();

            $this->reportData = [];
            return;
        }

        // 5. GROUPING Data Berdasarkan Tanggal
        // Kita group by format Y-m-d agar jam tidak memisahkan grup
        $groupedResults = $results->groupBy(function ($item) {
            return Carbon::parse($item->activity_date)->format('Y-m-d');
        });

        $finalReport = [];

        foreach ($groupedResults as $dateKey => $items) {
            // Mapping activities per tanggal
            $activities = $items->map(function ($item) {
                return [
                    'name' => $item->todo,
                    'comment' => $item->comment,
                    'photo' => $item->photo,
                    'status' => $item->is_checklist_id_checked ? 'Ya' : 'Tidak',
                    'karyawan' => $item->completed_by,
                    'kategori_aktivitas_shift_id' => $item->kategori_aktivitas_shift_id,
                    'shift_id' => $item->shift_id,
                ];
            });

            // Ambil completed_by dari item pertama di tanggal tersebut (asumsi shift management per hari)
            // Jika user bisa beda-beda per item, logic ini tetap aman karena tabel menampilkan kolom karyawan per baris
            $firstItem = $items->first();

            $finalReport[] = [
                'date_label' => Carbon::parse($dateKey)->isoFormat('dddd, D MMMM Y'), // Format Cantik: Senin, 1 November 2025
                'completed_by' => Auth::user()['name'], // Atau ambil dari $firstItem->completed_by jika ingin nama pelapor asli
                'activities' => $activities,
            ];
        }

        $this->reportData = $finalReport;
    }
}
