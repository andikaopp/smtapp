<x-filament-panels::page>

    {{-- BAGIAN FILTER --}}
    <x-filament::section :collapsible="true">
        <x-slot name="heading">
            Filter Laporan
        </x-slot>

        <form wire:submit="loadReport" class="space-y-4">
            {{ $this->form }}

            <x-filament::button type="submit" wire:loading.attr="disabled">
                <span wire:loading.remove>
                    Tampilkan Laporan
                </span>
                <span wire:loading>
                    Memuat...
                </span>
            </x-filament::button>
        </form>
    </x-filament::section>

    {{-- BAGIAN LAPORAN (HANYA MUNCUL JIKA ADA DATA) --}}
    @if ($reportData)
        <x-filament::section>
            <div class="space-y-4">

                {{-- HEADER LAPORAN --}}
                <div class="print:break-inside-avoid">
                    <h2 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                        Shift Management
                    </h2>

                    {{-- Garis pemisah --}}
                    <hr class="my-4 border-t border-gray-300 dark:border-gray-700">

                    {{-- Meta Data Laporan --}}
                    <div class="flex flex-col text-sm text-gray-400 dark:text-gray-300 sm:flex-row sm:justify-between">
                        <div class="space-y-1">
                            <p><span class="font-medium text-gray-600 dark:text-gray-400">Completed by:</span> {{ $reportData['completed_by'] }}</p>
                        </div>
                        <div class="mt-1 text-left sm:mt-0 sm:text-right">
                            <p><span class="font-medium text-gray-600 dark:text-gray-400">Date:</span> {{ $reportData['date'] }}</p>
                        </div>
                    </div>
                </div>

                {{-- Garis pemisah kedua --}}
                <hr class="my-2 border-t border-gray-300 dark:border-gray-700">

                <div class="mt-10 overflow-x-auto">
                    <p>Shift Pagi Kebersihan</p>
                    <hr class="my-2 border-t border-gray-300 dark:border-gray-700">
                    <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">

                        {{-- Ini menggantikan <thead> lama --}}
                        <tbody class="divide-y divide-gray-300 dark:divide-gray-700">
                        <tr class="print:break-inside-avoid">
                            <td class="w-3/4 px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Activity
                            </td>
                            <td class="w-3/4 px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Karyawan
                            </td>
                            <td class="w-1/4 px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Checklist
                            </td>
                        </tr>

                        {{-- Loop data aktivitas --}}
                        @forelse ($reportData['activities'] as $activity)
                            @if($activity['kategori_aktivitas_shift_id'] == "4" && $activity['shift_id'] == "1")
                            <tr class="print:break-inside-avoid">
                                <td class="px-6 py-3 align-top">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $activity['name'] }}
                                    </div>
                                    <div class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                        <strong>Komentar:</strong> {{ $activity['comment'] }}
                                    </div>
                                </td>
                                <td class="px-6 py-3 align-top">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $activity['karyawan'] }}
                                    </div>
                                </td>
                                <td class="px-6 py-3 text-right align-top">
                                    {{--
                                      STYLE BARU: Teks underline, bukan badge
                                      Berdasarkan screenshot 'image_d3b5e5.png'
                                    --}}
                                    <span class="text-sm font-medium text-gray-900 underline dark:text-white">
                                            {{ $activity['status'] }} {{-- Asumsi statusnya "Ya" atau "Tidak" --}}
                                        </span>
                                </td>
                            </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="2" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                    Tidak ada aktivitas ditemukan.
                                </td>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>
                </div>

                <div class="mt-10 overflow-x-auto">
                    <p>Shift Pagi - Pre Shift</p>
                    <hr class="my-2 border-t border-gray-300 dark:border-gray-700">
                    <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">

                        {{-- Ini menggantikan <thead> lama --}}
                        <tbody class="divide-y divide-gray-300 dark:divide-gray-700">
                        <tr class="print:break-inside-avoid">
                            <td class="w-3/4 px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Activity
                            </td>
                            <td class="w-3/4 px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Karyawan
                            </td>
                            <td class="w-1/4 px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Checklist
                            </td>
                        </tr>

                        {{-- Loop data aktivitas --}}
                        @forelse ($reportData['activities'] as $activity)
                            @if($activity['kategori_aktivitas_shift_id'] == "1" && $activity['shift_id'] == "1")
                                <tr class="print:break-inside-avoid">
                                    <td class="px-6 py-3 align-top">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $activity['name'] }}
                                        </div>
                                        <div class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                            <strong>Komentar:</strong> {{ $activity['comment'] }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-3 align-top">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $activity['karyawan'] }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-3 text-right align-top">
                                        {{--
                                          STYLE BARU: Teks underline, bukan badge
                                          Berdasarkan screenshot 'image_d3b5e5.png'
                                        --}}
                                        <span class="text-sm font-medium text-gray-900 underline dark:text-white">
                                            {{ $activity['status'] }} {{-- Asumsi statusnya "Ya" atau "Tidak" --}}
                                        </span>
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="2" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                    Tidak ada aktivitas ditemukan.
                                </td>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>
                </div>

                <div class="mt-10 overflow-x-auto">
                    <p>Shift Pagi - During Shift</p>
                    <hr class="my-2 border-t border-gray-300 dark:border-gray-700">
                    <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">

                        {{-- Ini menggantikan <thead> lama --}}
                        <tbody class="divide-y divide-gray-300 dark:divide-gray-700">
                        <tr class="print:break-inside-avoid">
                            <td class="w-3/4 px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Activity
                            </td>
                            <td class="w-3/4 px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Karyawan
                            </td>
                            <td class="w-1/4 px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Checklist
                            </td>
                        </tr>

                        {{-- Loop data aktivitas --}}
                        @forelse ($reportData['activities'] as $activity)
                            @if($activity['kategori_aktivitas_shift_id'] == "2" && $activity['shift_id'] == "1")
                                <tr class="print:break-inside-avoid">
                                    <td class="px-6 py-3 align-top">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $activity['name'] }}
                                        </div>
                                        <div class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                            <strong>Komentar:</strong> {{ $activity['comment'] }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-3 align-top">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $activity['karyawan'] }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-3 text-right align-top">
                                        {{--
                                          STYLE BARU: Teks underline, bukan badge
                                          Berdasarkan screenshot 'image_d3b5e5.png'
                                        --}}
                                        <span class="text-sm font-medium text-gray-900 underline dark:text-white">
                                            {{ $activity['status'] }} {{-- Asumsi statusnya "Ya" atau "Tidak" --}}
                                        </span>
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="2" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                    Tidak ada aktivitas ditemukan.
                                </td>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>
                </div>

                <div class="mt-10 overflow-x-auto">
                    <p>Shift Pagi - Post Shift</p>
                    <hr class="my-2 border-t border-gray-300 dark:border-gray-700">
                    <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">

                        {{-- Ini menggantikan <thead> lama --}}
                        <tbody class="divide-y divide-gray-300 dark:divide-gray-700">
                        <tr class="print:break-inside-avoid">
                            <td class="w-3/4 px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Activity
                            </td>
                            <td class="w-3/4 px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Karyawan
                            </td>
                            <td class="w-1/4 px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Checklist
                            </td>
                        </tr>

                        {{-- Loop data aktivitas --}}
                        @forelse ($reportData['activities'] as $activity)
                            @if($activity['kategori_aktivitas_shift_id'] == "3" && $activity['shift_id'] == "1")
                                <tr class="print:break-inside-avoid">
                                    <td class="px-6 py-3 align-top">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $activity['name'] }}
                                        </div>
                                        <div class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                            <strong>Komentar:</strong> {{ $activity['comment'] }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-3 align-top">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $activity['karyawan'] }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-3 text-right align-top">
                                        {{--
                                          STYLE BARU: Teks underline, bukan badge
                                          Berdasarkan screenshot 'image_d3b5e5.png'
                                        --}}
                                        <span class="text-sm font-medium text-gray-900 underline dark:text-white">
                                            {{ $activity['status'] }} {{-- Asumsi statusnya "Ya" atau "Tidak" --}}
                                        </span>
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="2" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                    Tidak ada aktivitas ditemukan.
                                </td>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>
                </div>


                {{-- Garis pemisah kedua --}}
                <hr class="my-2 border-t border-gray-300 dark:border-gray-700">

                <div class="mt-10 overflow-x-auto">
                    <p>Shift Siang Kebersihan</p>
                    <hr class="my-2 border-t border-gray-300 dark:border-gray-700">
                    <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">

                        {{-- Ini menggantikan <thead> lama --}}
                        <tbody class="divide-y divide-gray-300 dark:divide-gray-700">
                        <tr class="print:break-inside-avoid">
                            <td class="w-3/4 px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Activity
                            </td>
                            <td class="w-3/4 px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Karyawan
                            </td>
                            <td class="w-1/4 px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Checklist
                            </td>
                        </tr>

                        {{-- Loop data aktivitas --}}
                        @forelse ($reportData['activities'] as $activity)
                            @if($activity['kategori_aktivitas_shift_id'] == "5" && $activity['shift_id'] == "2")
                                <tr class="print:break-inside-avoid">
                                    <td class="px-6 py-3 align-top">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $activity['name'] }}
                                        </div>
                                        <div class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                            <strong>Komentar:</strong> {{ $activity['comment'] }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-3 align-top">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $activity['karyawan'] }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-3 text-right align-top">
                                        {{--
                                          STYLE BARU: Teks underline, bukan badge
                                          Berdasarkan screenshot 'image_d3b5e5.png'
                                        --}}
                                        <span class="text-sm font-medium text-gray-900 underline dark:text-white">
                                            {{ $activity['status'] }} {{-- Asumsi statusnya "Ya" atau "Tidak" --}}
                                        </span>
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="2" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                    Tidak ada aktivitas ditemukan.
                                </td>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>
                </div>

                <div class="mt-10 overflow-x-auto">
                    <p>Shift Siang - Pre Shift</p>
                    <hr class="my-2 border-t border-gray-300 dark:border-gray-700">
                    <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">

                        {{-- Ini menggantikan <thead> lama --}}
                        <tbody class="divide-y divide-gray-300 dark:divide-gray-700">
                        <tr class="print:break-inside-avoid">
                            <td class="w-3/4 px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Activity
                            </td>
                            <td class="w-3/4 px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Karyawan
                            </td>
                            <td class="w-1/4 px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Checklist
                            </td>
                        </tr>

                        {{-- Loop data aktivitas --}}
                        @forelse ($reportData['activities'] as $activity)
                            @if($activity['kategori_aktivitas_shift_id'] == "1" && $activity['shift_id'] == "2")
                                <tr class="print:break-inside-avoid">
                                    <td class="px-6 py-3 align-top">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $activity['name'] }}
                                        </div>
                                        <div class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                            <strong>Komentar:</strong> {{ $activity['comment'] }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-3 align-top">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $activity['karyawan'] }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-3 text-right align-top">
                                        {{--
                                          STYLE BARU: Teks underline, bukan badge
                                          Berdasarkan screenshot 'image_d3b5e5.png'
                                        --}}
                                        <span class="text-sm font-medium text-gray-900 underline dark:text-white">
                                            {{ $activity['status'] }} {{-- Asumsi statusnya "Ya" atau "Tidak" --}}
                                        </span>
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="2" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                    Tidak ada aktivitas ditemukan.
                                </td>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>
                </div>

                <div class="mt-10 overflow-x-auto">
                    <p>Shift Siang - During Shift</p>
                    <hr class="my-2 border-t border-gray-300 dark:border-gray-700">
                    <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">

                        {{-- Ini menggantikan <thead> lama --}}
                        <tbody class="divide-y divide-gray-300 dark:divide-gray-700">
                        <tr class="print:break-inside-avoid">
                            <td class="w-3/4 px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Activity
                            </td>
                            <td class="w-3/4 px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Karyawan
                            </td>
                            <td class="w-1/4 px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Checklist
                            </td>
                        </tr>

                        {{-- Loop data aktivitas --}}
                        @forelse ($reportData['activities'] as $activity)
                            @if($activity['kategori_aktivitas_shift_id'] == "2" && $activity['shift_id'] == "2")
                                <tr class="print:break-inside-avoid">
                                    <td class="px-6 py-3 align-top">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $activity['name'] }}
                                        </div>
                                        <div class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                            <strong>Komentar:</strong> {{ $activity['comment'] }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-3 align-top">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $activity['karyawan'] }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-3 text-right align-top">
                                        {{--
                                          STYLE BARU: Teks underline, bukan badge
                                          Berdasarkan screenshot 'image_d3b5e5.png'
                                        --}}
                                        <span class="text-sm font-medium text-gray-900 underline dark:text-white">
                                            {{ $activity['status'] }} {{-- Asumsi statusnya "Ya" atau "Tidak" --}}
                                        </span>
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="2" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                    Tidak ada aktivitas ditemukan.
                                </td>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>
                </div>

                <div class="mt-10 overflow-x-auto">
                    <p>Shift Siang - Post Shift</p>
                    <hr class="my-2 border-t border-gray-300 dark:border-gray-700">
                    <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">

                        {{-- Ini menggantikan <thead> lama --}}
                        <tbody class="divide-y divide-gray-300 dark:divide-gray-700">
                        <tr class="print:break-inside-avoid">
                            <td class="w-3/4 px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Activity
                            </td>
                            <td class="w-3/4 px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Karyawan
                            </td>
                            <td class="w-1/4 px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Checklist
                            </td>
                        </tr>

                        {{-- Loop data aktivitas --}}
                        @forelse ($reportData['activities'] as $activity)
                            @if($activity['kategori_aktivitas_shift_id'] == "3" && $activity['shift_id'] == "2")
                                <tr class="print:break-inside-avoid">
                                    <td class="px-6 py-3 align-top">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $activity['name'] }}
                                        </div>
                                        <div class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                            <strong>Komentar:</strong> {{ $activity['comment'] }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-3 align-top">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $activity['karyawan'] }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-3 text-right align-top">
                                        {{--
                                          STYLE BARU: Teks underline, bukan badge
                                          Berdasarkan screenshot 'image_d3b5e5.png'
                                        --}}
                                        <span class="text-sm font-medium text-gray-900 underline dark:text-white">
                                            {{ $activity['status'] }} {{-- Asumsi statusnya "Ya" atau "Tidak" --}}
                                        </span>
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="2" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                    Tidak ada aktivitas ditemukan.
                                </td>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>
                </div>

            </div>
        </x-filament::section>

        {{-- Tampilan jika data belum difilter --}}
    @else
        <x-filament::section>
            <div class="py-12 text-center">
                <x-filament::icon
                    icon="heroicon-o-document-magnifying-glass"
                    class="mx-auto h-12 w-12 text-gray-400"
                />
                <h3 class="mt-2 text-sm font-semibold text-gray-900 dark:text-white">
                    Belum Ada Laporan
                </h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Silakan pilih filter di atas dan klik "Tampilkan Laporan" untuk memuat data.
                </p>
            </div>
        </x-filament::section>
    @endif

</x-filament-panels::page>
