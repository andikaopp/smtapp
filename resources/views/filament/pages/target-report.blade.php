<x-filament-panels::page>

    {{-- BAGIAN FILTER --}}
    <x-filament::section :collapsible="true">
        <x-slot name="heading">
            Filter Laporan (Range Tanggal)
        </x-slot>

        <form wire:submit="loadReport" class="space-y-4">
            {{ $this->form }}

            <div class="flex justify-end">
                <x-filament::button type="submit" wire:loading.attr="disabled">
                    <span wire:loading.remove>
                        Tampilkan Laporan
                    </span>
                    <span wire:loading>
                        Memuat...
                    </span>
                </x-filament::button>
            </div>
        </form>
    </x-filament::section>

    {{--
        BAGIAN LAPORAN
        Kita melakukan looping terhadap $reportData karena sekarang isinya adalah array of reports per tanggal
    --}}
    @if (!empty($reportData))

        @foreach($reportData as $dailyReport)
            {{-- Tambahkan mb-8 agar ada jarak antar hari --}}
            <x-filament::section class="mb-8 border-l-4 border-primary-500">
                <div class="space-y-4">

                    {{-- HEADER LAPORAN PER HARI --}}
                    <div class="print:break-inside-avoid">
                        <h2 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                            Shift Management
                        </h2>

                        {{-- Garis pemisah --}}
                        <hr class="my-4 border-t border-gray-300 dark:border-gray-700">

                        {{-- Meta Data Laporan --}}
                        <div class="flex flex-col text-sm text-gray-400 dark:text-gray-300 sm:flex-row sm:justify-between">
                            <div class="space-y-1">
                                {{-- Menggunakan data dari loop $dailyReport --}}
                                <p><span class="font-medium text-gray-600 dark:text-gray-400">Completed by:</span> {{ $dailyReport['completed_by'] }}</p>
                            </div>
                            <div class="mt-1 text-left sm:mt-0 sm:text-right">
                                {{-- Tanggal spesifik untuk blok laporan ini --}}
                                <p><span class="font-medium text-gray-600 dark:text-gray-400">Date:</span> <span class="text-lg font-bold text-primary-600">{{ $dailyReport['date_label'] }}</span></p>
                            </div>
                        </div>
                    </div>

                    {{-- Garis pemisah kedua --}}
                    <hr class="my-2 border-t border-gray-300 dark:border-gray-700">

                    {{-- TABEL 1: Shift Pagi Kebersihan --}}
                    <div class="mt-10 overflow-x-auto">
                        <p class="font-semibold text-gray-700 dark:text-gray-200">Shift Pagi Kebersihan</p>
                        <hr class="my-2 border-t border-gray-300 dark:border-gray-700">
                        <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">
                            <tbody class="divide-y divide-gray-300 dark:divide-gray-700">
                            <tr class="print:break-inside-avoid bg-gray-50 dark:bg-gray-800">
                                <td class="w-3/4 px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Activity</td>
                                <td class="w-3/4 px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Karyawan</td>
                                <td class="w-1/4 px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Status</td>
                            </tr>

                            {{-- Loop activities dari dailyReport --}}
                            @php $hasData = false; @endphp
                            @foreach ($dailyReport['activities'] as $activity)
                                @if($activity['kategori_aktivitas_shift_id'] == "4" && $activity['shift_id'] == "1")
                                    @php $hasData = true; @endphp
                                    <tr class="print:break-inside-avoid">
                                        <td class="px-6 py-3 align-top">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $activity['name'] }}
                                            </div>
                                            <div class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                                <strong>Komentar:</strong> {{ $activity['comment'] }}
                                            </div>
                                            <div class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                                <strong>Photo:</strong>
                                                @if($activity['photo'] == null)
                                                    <span>-</span>
                                                @else
                                                    <img
                                                        src="{{ asset('storage/' . $activity['photo']) }}"
                                                        class="w-16 h-16 mt-1 rounded-md object-cover"
                                                        @click="$dispatch('open-image', { src: '{{ asset('storage/' . $activity['photo']) }}' })"
                                                    />
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-3 align-top">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $activity['karyawan'] }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-3 text-right align-top">
                                        <span class="text-sm font-medium text-gray-900 underline dark:text-white">
                                            {{ $activity['status'] }}
                                        </span>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach

                            @if(!$hasData)
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400 italic">
                                        Tidak ada aktivitas Shift Pagi Kebersihan.
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>

                    {{-- TABEL 2: Shift Pagi - Pre Shift --}}
                    <div class="mt-10 overflow-x-auto">
                        <p class="font-semibold text-gray-700 dark:text-gray-200">Shift Pagi - Pre Shift</p>
                        <hr class="my-2 border-t border-gray-300 dark:border-gray-700">
                        <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">
                            <tbody class="divide-y divide-gray-300 dark:divide-gray-700">
                            <tr class="print:break-inside-avoid bg-gray-50 dark:bg-gray-800">
                                <td class="w-3/4 px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Activity</td>
                                <td class="w-3/4 px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Karyawan</td>
                                <td class="w-1/4 px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Status</td>
                            </tr>

                            @php $hasData = false; @endphp
                            @foreach ($dailyReport['activities'] as $activity)
                                @if($activity['kategori_aktivitas_shift_id'] == "1" && $activity['shift_id'] == "1")
                                    @php $hasData = true; @endphp
                                    <tr class="print:break-inside-avoid">
                                        <td class="px-6 py-3 align-top">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $activity['name'] }}
                                            </div>
                                            <div class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                                <strong>Komentar:</strong> {{ $activity['comment'] }}
                                            </div>
                                            <div class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                                <strong>Photo:</strong>
                                                @if($activity['photo'] == null)
                                                    <span>-</span>
                                                @else
                                                    <img
                                                        src="{{ asset('storage/' . $activity['photo']) }}"
                                                        class="w-16 h-16 mt-1 rounded-md object-cover"
                                                        @click="$dispatch('open-image', { src: '{{ asset('storage/' . $activity['photo']) }}' })"
                                                    />
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-3 align-top">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $activity['karyawan'] }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-3 text-right align-top">
                                            <span class="text-sm font-medium text-gray-900 underline dark:text-white">
                                                {{ $activity['status'] }}
                                            </span>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            @if(!$hasData)
                                <tr><td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500 italic">Tidak ada aktivitas.</td></tr>
                            @endif
                            </tbody>
                        </table>
                    </div>

                    {{-- TABEL 3: Shift Pagi - During Shift --}}
                    <div class="mt-10 overflow-x-auto">
                        <p class="font-semibold text-gray-700 dark:text-gray-200">Shift Pagi - During Shift</p>
                        <hr class="my-2 border-t border-gray-300 dark:border-gray-700">
                        <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">
                            <tbody class="divide-y divide-gray-300 dark:divide-gray-700">
                            <tr class="print:break-inside-avoid bg-gray-50 dark:bg-gray-800">
                                <td class="w-3/4 px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Activity</td>
                                <td class="w-3/4 px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Karyawan</td>
                                <td class="w-1/4 px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Status</td>
                            </tr>
                            @php $hasData = false; @endphp
                            @foreach ($dailyReport['activities'] as $activity)
                                @if($activity['kategori_aktivitas_shift_id'] == "2" && $activity['shift_id'] == "1")
                                    @php $hasData = true; @endphp
                                    <tr class="print:break-inside-avoid">
                                        <td class="px-6 py-3 align-top">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $activity['name'] }}
                                            </div>
                                            <div class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                                <strong>Komentar:</strong> {{ $activity['comment'] }}
                                            </div>
                                            <div class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                                <strong>Photo:</strong>
                                                @if($activity['photo'] == null)
                                                    <span>-</span>
                                                @else
                                                    <img
                                                        src="{{ asset('storage/' . $activity['photo']) }}"
                                                        class="w-16 h-16 mt-1 rounded-md object-cover"
                                                        @click="$dispatch('open-image', { src: '{{ asset('storage/' . $activity['photo']) }}' })"
                                                    />
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-3 align-top">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $activity['karyawan'] }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-3 text-right align-top">
                                            <span class="text-sm font-medium text-gray-900 underline dark:text-white">
                                                {{ $activity['status'] }}
                                            </span>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            @if(!$hasData)
                                <tr><td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500 italic">Tidak ada aktivitas.</td></tr>
                            @endif
                            </tbody>
                        </table>
                    </div>

                    {{-- TABEL 4: Shift Pagi - Post Shift --}}
                    <div class="mt-10 overflow-x-auto">
                        <p class="font-semibold text-gray-700 dark:text-gray-200">Shift Pagi - Post Shift</p>
                        <hr class="my-2 border-t border-gray-300 dark:border-gray-700">
                        <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">
                            <tbody class="divide-y divide-gray-300 dark:divide-gray-700">
                            <tr class="print:break-inside-avoid bg-gray-50 dark:bg-gray-800">
                                <td class="w-3/4 px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Activity</td>
                                <td class="w-3/4 px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Karyawan</td>
                                <td class="w-1/4 px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Status</td>
                            </tr>
                            @php $hasData = false; @endphp
                            @foreach ($dailyReport['activities'] as $activity)
                                @if($activity['kategori_aktivitas_shift_id'] == "3" && $activity['shift_id'] == "1")
                                    @php $hasData = true; @endphp
                                    <tr class="print:break-inside-avoid">
                                        <td class="px-6 py-3 align-top">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $activity['name'] }}
                                            </div>
                                            <div class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                                <strong>Komentar:</strong> {{ $activity['comment'] }}
                                            </div>
                                            <div class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                                <strong>Photo:</strong>
                                                @if($activity['photo'] == null)
                                                    <span>-</span>
                                                @else
                                                    <img
                                                        src="{{ asset('storage/' . $activity['photo']) }}"
                                                        class="w-16 h-16 mt-1 rounded-md object-cover"
                                                        @click="$dispatch('open-image', { src: '{{ asset('storage/' . $activity['photo']) }}' })"
                                                    />
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-3 align-top">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $activity['karyawan'] }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-3 text-right align-top">
                                            <span class="text-sm font-medium text-gray-900 underline dark:text-white">
                                                {{ $activity['status'] }}
                                            </span>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            @if(!$hasData)
                                <tr><td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500 italic">Tidak ada aktivitas.</td></tr>
                            @endif
                            </tbody>
                        </table>
                    </div>


                    {{-- Garis pemisah SIANG --}}
                    <hr class="my-2 border-t border-gray-300 dark:border-gray-700 mt-8">

                    {{-- TABEL 5: Shift Siang Kebersihan --}}
                    <div class="mt-10 overflow-x-auto">
                        <p class="font-semibold text-gray-700 dark:text-gray-200">Shift Siang Kebersihan</p>
                        <hr class="my-2 border-t border-gray-300 dark:border-gray-700">
                        <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">
                            <tbody class="divide-y divide-gray-300 dark:divide-gray-700">
                            <tr class="print:break-inside-avoid bg-gray-50 dark:bg-gray-800">
                                <td class="w-3/4 px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Activity</td>
                                <td class="w-3/4 px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Karyawan</td>
                                <td class="w-1/4 px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Status</td>
                            </tr>
                            @php $hasData = false; @endphp
                            @foreach ($dailyReport['activities'] as $activity)
                                @if($activity['kategori_aktivitas_shift_id'] == "5" && $activity['shift_id'] == "2")
                                    @php $hasData = true; @endphp
                                    <tr class="print:break-inside-avoid">
                                        <td class="px-6 py-3 align-top">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $activity['name'] }}
                                            </div>
                                            <div class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                                <strong>Komentar:</strong> {{ $activity['comment'] }}
                                            </div>
                                            <div class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                                <strong>Photo:</strong>
                                                @if($activity['photo'] == null)
                                                    <span>-</span>
                                                @else
                                                    <img
                                                        src="{{ asset('storage/' . $activity['photo']) }}"
                                                        class="w-16 h-16 mt-1 rounded-md object-cover"
                                                        @click="$dispatch('open-image', { src: '{{ asset('storage/' . $activity['photo']) }}' })"
                                                    />
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-3 align-top">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $activity['karyawan'] }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-3 text-right align-top">
                                            <span class="text-sm font-medium text-gray-900 underline dark:text-white">
                                                {{ $activity['status'] }}
                                            </span>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            @if(!$hasData)
                                <tr><td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500 italic">Tidak ada aktivitas.</td></tr>
                            @endif
                            </tbody>
                        </table>
                    </div>

                    {{-- TABEL 6: Shift Siang - Pre Shift --}}
                    <div class="mt-10 overflow-x-auto">
                        <p class="font-semibold text-gray-700 dark:text-gray-200">Shift Siang - Pre Shift</p>
                        <hr class="my-2 border-t border-gray-300 dark:border-gray-700">
                        <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">
                            <tbody class="divide-y divide-gray-300 dark:divide-gray-700">
                            <tr class="print:break-inside-avoid bg-gray-50 dark:bg-gray-800">
                                <td class="w-3/4 px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Activity</td>
                                <td class="w-3/4 px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Karyawan</td>
                                <td class="w-1/4 px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Status</td>
                            </tr>
                            @php $hasData = false; @endphp
                            @foreach ($dailyReport['activities'] as $activity)
                                @if($activity['kategori_aktivitas_shift_id'] == "1" && $activity['shift_id'] == "2")
                                    @php $hasData = true; @endphp
                                    <tr class="print:break-inside-avoid">
                                        <td class="px-6 py-3 align-top">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $activity['name'] }}
                                            </div>
                                            <div class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                                <strong>Komentar:</strong> {{ $activity['comment'] }}
                                            </div>
                                            <div class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                                <strong>Photo:</strong>
                                                @if($activity['photo'] == null)
                                                    <span>-</span>
                                                @else
                                                    <img
                                                        src="{{ asset('storage/' . $activity['photo']) }}"
                                                        class="w-16 h-16 mt-1 rounded-md object-cover"
                                                        @click="$dispatch('open-image', { src: '{{ asset('storage/' . $activity['photo']) }}' })"
                                                    />
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-3 align-top">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $activity['karyawan'] }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-3 text-right align-top">
                                            <span class="text-sm font-medium text-gray-900 underline dark:text-white">
                                                {{ $activity['status'] }}
                                            </span>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            @if(!$hasData)
                                <tr><td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500 italic">Tidak ada aktivitas.</td></tr>
                            @endif
                            </tbody>
                        </table>
                    </div>

                    {{-- TABEL 7: Shift Siang - During Shift --}}
                    <div class="mt-10 overflow-x-auto">
                        <p class="font-semibold text-gray-700 dark:text-gray-200">Shift Siang - During Shift</p>
                        <hr class="my-2 border-t border-gray-300 dark:border-gray-700">
                        <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">
                            <tbody class="divide-y divide-gray-300 dark:divide-gray-700">
                            <tr class="print:break-inside-avoid bg-gray-50 dark:bg-gray-800">
                                <td class="w-3/4 px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Activity</td>
                                <td class="w-3/4 px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Karyawan</td>
                                <td class="w-1/4 px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Status</td>
                            </tr>
                            @php $hasData = false; @endphp
                            @foreach ($dailyReport['activities'] as $activity)
                                @if($activity['kategori_aktivitas_shift_id'] == "2" && $activity['shift_id'] == "2")
                                    @php $hasData = true; @endphp
                                    <tr class="print:break-inside-avoid">
                                        <td class="px-6 py-3 align-top">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $activity['name'] }}
                                            </div>
                                            <div class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                                <strong>Komentar:</strong> {{ $activity['comment'] }}
                                            </div>
                                            <div class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                                <strong>Photo:</strong>
                                                @if($activity['photo'] == null)
                                                    <span>-</span>
                                                @else
                                                    <img
                                                        src="{{ asset('storage/' . $activity['photo']) }}"
                                                        class="w-16 h-16 mt-1 rounded-md object-cover"
                                                        @click="$dispatch('open-image', { src: '{{ asset('storage/' . $activity['photo']) }}' })"
                                                    />
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-3 align-top">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $activity['karyawan'] }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-3 text-right align-top">
                                            <span class="text-sm font-medium text-gray-900 underline dark:text-white">
                                                {{ $activity['status'] }}
                                            </span>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            @if(!$hasData)
                                <tr><td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500 italic">Tidak ada aktivitas.</td></tr>
                            @endif
                            </tbody>
                        </table>
                    </div>

                    {{-- TABEL 8: Shift Siang - Post Shift --}}
                    <div class="mt-10 overflow-x-auto">
                        <p class="font-semibold text-gray-700 dark:text-gray-200">Shift Siang - Post Shift</p>
                        <hr class="my-2 border-t border-gray-300 dark:border-gray-700">
                        <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">
                            <tbody class="divide-y divide-gray-300 dark:divide-gray-700">
                            <tr class="print:break-inside-avoid bg-gray-50 dark:bg-gray-800">
                                <td class="w-3/4 px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Activity</td>
                                <td class="w-3/4 px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Karyawan</td>
                                <td class="w-1/4 px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Status</td>
                            </tr>
                            @php $hasData = false; @endphp
                            @foreach ($dailyReport['activities'] as $activity)
                                @if($activity['kategori_aktivitas_shift_id'] == "3" && $activity['shift_id'] == "2")
                                    @php $hasData = true; @endphp
                                    <tr class="print:break-inside-avoid">
                                        <td class="px-6 py-3 align-top">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $activity['name'] }}
                                            </div>
                                            <div class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                                <strong>Komentar:</strong> {{ $activity['comment'] }}
                                            </div>
                                            <div class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                                <strong>Photo:</strong>
                                                @if($activity['photo'] == null)
                                                    <span>-</span>
                                                @else
                                                    <img
                                                        src="{{ asset('storage/' . $activity['photo']) }}"
                                                        class="w-16 h-16 mt-1 rounded-md object-cover"
                                                        @click="$dispatch('open-image', { src: '{{ asset('storage/' . $activity['photo']) }}' })"
                                                    />
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-3 align-top">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $activity['karyawan'] }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-3 text-right align-top">
                                            <span class="text-sm font-medium text-gray-900 underline dark:text-white">
                                                {{ $activity['status'] }}
                                            </span>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            @if(!$hasData)
                                <tr><td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500 italic">Tidak ada aktivitas.</td></tr>
                            @endif
                            </tbody>
                        </table>
                    </div>

                </div>
            </x-filament::section>
        @endforeach

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
                    Silakan pilih range tanggal dan cabang, lalu klik "Tampilkan Laporan".
                </p>
            </div>
        </x-filament::section>
    @endif
    <div
        x-data="{ open: false, imageSrc: '' }"
        x-on:open-image.window="
        imageSrc = $event.detail.src;
        open = true;
    "
    >
        <!-- Modal -->
        <div
            x-show="open"
            x-transition.opacity
            class="fixed inset-0 bg-black/80 flex items-center justify-center z-50"
            @click.self="open = false"
        >
            <img
                :src="imageSrc"
                class="max-w-[90%] max-h-[90%] rounded-lg shadow-lg"
                x-transition.scale.50
            >
        </div>
    </div>

</x-filament-panels::page>
