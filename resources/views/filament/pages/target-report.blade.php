<x-filament-panels::page>
    {{--
        Anda bisa menambahkan style kustom di sini jika diperlukan.
        Filament sudah menggunakan Tailwind CSS, jadi class utility bisa langsung dipakai.
    --}}
    <style>
        th, td {
            white-space: nowrap; /* Mencegah teks pada header dan sel turun ke baris baru */
        }
    </style>

    {{--
        Struktur HTML dari laporan Anda dimulai di sini.
        Saya membungkusnya dalam div dengan class fi-section untuk konsistensi tampilan Filament.
    --}}
    <div class="fi-section overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">

        {{-- Wrapper untuk membuat tabel bisa di-scroll secara horizontal di layar kecil --}}
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm border-collapse">
                <thead class="bg-gray-50 dark:bg-gray-800">
                <!-- Baris Header Utama (Opening, Siang) -->
                <tr>
                    <th rowspan="2" class="border border-gray-300 dark:border-gray-600 p-2 font-semibold text-gray-700 dark:text-gray-200"></th>
                    <th colspan="7" class="border border-gray-300 dark:border-gray-600 p-2 font-bold text-gray-800 dark:text-gray-100 bg-yellow-300 dark:bg-yellow-700">Opening</th>
                    <th colspan="7" class="border border-gray-300 dark:border-gray-600 p-2 font-bold text-gray-800 dark:text-gray-100 bg-cyan-300 dark:bg-cyan-700">Siang</th>
                </tr>
                <!-- Baris Header Detail Kolom -->
                <tr>
                    <!-- Kolom untuk Sesi "Opening" -->
                    <th class="border border-gray-300 dark:border-gray-600 p-2 font-semibold text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-700/50">Target Omset Global</th>
                    <th class="border border-gray-300 dark:border-gray-600 p-2 font-semibold text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-700/50">Target Omset Retail</th>
                    <th class="border border-gray-300 dark:border-gray-600 p-2 font-semibold text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-700/50">Actual Omset Retail</th>
                    <th class="border border-gray-300 dark:border-gray-600 p-2 font-semibold text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-700/50">Achievement Retail %</th>
                    <th class="border border-gray-300 dark:border-gray-600 p-2 font-semibold text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-700/50">Target Omset Pesanan</th>
                    <th class="border border-gray-300 dark:border-gray-600 p-2 font-semibold text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-700/50">Actual Omset Pesanan</th>
                    <th class="border border-gray-300 dark:border-gray-600 p-2 font-semibold text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-700/50">Achievement Pesanan %</th>

                    <!-- Kolom untuk Sesi "Siang" -->
                    <th class="border border-gray-300 dark:border-gray-600 p-2 font-semibold text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-700/50">Actual Omset Global</th>
                    <th class="border border-gray-300 dark:border-gray-600 p-2 font-semibold text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-700/50">Target Omset Retail</th>
                    <th class="border border-gray-300 dark:border-gray-600 p-2 font-semibold text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-700/50">Actual Omset Retail</th>
                    <th class="border border-gray-300 dark:border-gray-600 p-2 font-semibold text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-700/50">Achievement Retail %</th>
                    <th class="border border-gray-300 dark:border-gray-600 p-2 font-semibold text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-700/50">Target Omset Pesanan</th>
                    <th class="border border-gray-300 dark:border-gray-600 p-2 font-semibold text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-700/50">Actual Omset Pesanan</th>
                    <th class="border border-gray-300 dark:border-gray-600 p-2 font-semibold text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-700/50">Achievement Pesanan %</th>
                </tr>
                </thead>
                <tbody class="text-gray-700 dark:text-gray-200">
                <!-- Baris Data (Nantinya bisa di-loop dari data dinamis) -->
                <tr>
                    <td class="border border-gray-300 dark:border-gray-600 p-2 font-medium bg-gray-50 dark:bg-gray-800">Omset</td>
                    <td class="border border-gray-300 dark:border-gray-600 p-2 text-right">{{ $dataTargetPagi?->omset_global }}</td>
                    <td class="border border-gray-300 dark:border-gray-600 p-2 text-right">{{ $dataTargetPagi?->omset_retail }}</td>
                    <td class="border border-gray-300 dark:border-gray-600 p-2 text-right">{{ $dataActualPagi?->actual_omset_retail }}</td>
                    <td class="border border-gray-300 dark:border-gray-600 p-2 text-right">{{ ($dataActualPagi?->actual_omset_retail/$dataTargetPagi?->omset_retail)*100 }} %</td>
                    <td class="border border-gray-300 dark:border-gray-600 p-2 text-right">{{ $dataTargetPagi?->omset_pesanan }}</td>
                    <td class="border border-gray-300 dark:border-gray-600 p-2 text-right">{{ $dataActualPagi?->actual_omset_pesanan }}</td>
                    <td class="border border-gray-300 dark:border-gray-600 p-2 text-right">{{ ($dataActualPagi?->actual_omset_pesanan/$dataTargetPagi?->omset_pesanan)*100 }} %</td>

                    <td class="border border-gray-300 dark:border-gray-600 p-2 text-right">{{ $dataActualSiang?->actual_omset_global }}</td>
                    <td class="border border-gray-300 dark:border-gray-600 p-2 text-right">{{ $dataTargetSiang?->omset_retail }}</td>
                    <td class="border border-gray-300 dark:border-gray-600 p-2 text-right">{{ $dataActualSiang?->actual_omset_retail }}</td>
                    <td class="border border-gray-300 dark:border-gray-600 p-2 text-right">{{ ($dataActualSiang?->actual_omset_retail/$dataTargetSiang?->omset_retail)*100 }} %</td>
                    <td class="border border-gray-300 dark:border-gray-600 p-2 text-right">{{ $dataTargetSiang?->omset_pesanan }}</td>
                    <td class="border border-gray-300 dark:border-gray-600 p-2 text-right">{{ $dataActualSiang?->actual_omset_pesanan }}</td>
                    <td class="border border-gray-300 dark:border-gray-600 p-2 text-right">{{ ceil(($dataActualSiang?->actual_omset_pesanan/$dataTargetSiang?->omset_pesanan)*100) }} %</td>
                </tr>
                <tr>
                    <td class="border border-gray-300 dark:border-gray-600 p-2 font-medium bg-gray-50 dark:bg-gray-800">TC</td>
                    <td class="border border-gray-300 dark:border-gray-600 p-2 text-right">{{ $dataTargetPagi?->tc_global }}</td>
                    <td class="border border-gray-300 dark:border-gray-600 p-2 text-right">{{ $dataTargetPagi?->tc_retail }}</td>
                    <td class="border border-gray-300 dark:border-gray-600 p-2 text-right">{{ $dataActualPagi?->actual_tc_retail }}</td>
                    <td class="border border-gray-300 dark:border-gray-600 p-2 text-right"></td>
                    <td class="border border-gray-300 dark:border-gray-600 p-2 text-right">{{ $dataTargetPagi?->tc_pesanan }}</td>
                    <td class="border border-gray-300 dark:border-gray-600 p-2 text-right">{{ $dataActualPagi?->actual_tc_pesanan }}</td>
                    <td class="border border-gray-300 dark:border-gray-600 p-2 text-right"></td>

                    <td class="border border-gray-300 dark:border-gray-600 p-2 text-right">{{ $dataActualSiang?->actual_tc_global }}</td>
                    <td class="border border-gray-300 dark:border-gray-600 p-2 text-right"></td>
                    <td class="border border-gray-300 dark:border-gray-600 p-2 text-right">{{ $dataActualSiang?->actual_tc_retail }}</td>
                    <td class="border border-gray-300 dark:border-gray-600 p-2 text-right"></td>
                    <td class="border border-gray-300 dark:border-gray-600 p-2 text-right"></td>
                    <td class="border border-gray-300 dark:border-gray-600 p-2 text-right">{{ $dataActualSiang?->actual_tc_pesanan }}</td>
                    <td class="border border-gray-300 dark:border-gray-600 p-2 text-right"></td>
                </tr>
                <tr>
                    <td class="border border-gray-300 dark:border-gray-600 p-2 font-medium bg-gray-50 dark:bg-gray-800">Target Lainnya</td>
                    <td class="border border-gray-300 dark:border-gray-600 p-2 text-right">{{ $dataTargetPagi?->target_lainnya }}</td>
                    <td class="border border-gray-300 dark:border-gray-600 p-2 text-right">{{ $dataActualPagi?->actual_target_lainnya }}</td>
                    <td class="border border-gray-300 dark:border-gray-600 p-2 text-right"></td>
                    <td class="border border-gray-300 dark:border-gray-600 p-2 text-right"></td>
                    <td class="border border-gray-300 dark:border-gray-600 p-2 text-right"></td>
                    <td class="border border-gray-300 dark:border-gray-600 p-2 text-right"></td>
                    <td class="border border-gray-300 dark:border-gray-600 p-2 text-right"></td>

                    <td class="border border-gray-300 dark:border-gray-600 p-2 text-right">{{ $dataTargetSiang?->target_lainnya }}</td>
                    <td class="border border-gray-300 dark:border-gray-600 p-2 text-right">{{ $dataActualSiang?->actual_target_lainnya }}</td>
                    <td class="border border-gray-300 dark:border-gray-600 p-2 text-right"></td>
                    <td class="border border-gray-300 dark:border-gray-600 p-2 text-right"></td>
                    <td class="border border-gray-300 dark:border-gray-600 p-2 text-right"></td>
                    <td class="border border-gray-300 dark:border-gray-600 p-2 text-right"></td>
                    <td class="border border-gray-300 dark:border-gray-600 p-2 text-right"></td>
                </tr>
                <tr>
                    <td class="border border-gray-300 dark:border-gray-600 p-2 font-medium bg-gray-50 dark:bg-gray-800">Nama Staff/Leader</td>
                    <td class="border border-gray-300 dark:border-gray-600 p-2" colspan="7">{{ $dataTargetPagi?->user->name }}</td>
                    <td class="border border-gray-300 dark:border-gray-600 p-2" colspan="7">{{ $dataTargetSiang?->user->name }}</td>
                </tr>
                <tr>
                    <td class="border border-gray-300 dark:border-gray-600 p-2 font-medium bg-gray-50 dark:bg-gray-800">All day Omset/target</td>
                    <td colspan="4" class="border border-gray-300 dark:border-gray-600 p-2 bg-gray-200 dark:bg-gray-700"></td>
                    <td class="border border-gray-300 dark:border-gray-600 p-2"></td>
                    <td class="border border-gray-300 dark:border-gray-600 p-2"></td>
                    <td class="border border-gray-300 dark:border-gray-600 p-2"></td>
                    <td colspan="4" class="border border-gray-300 dark:border-gray-600 p-2 bg-gray-200 dark:bg-gray-700"></td>
                    <td class="border border-gray-300 dark:border-gray-600 p-2"></td>
                    <td class="border border-gray-300 dark:border-gray-600 p-2"></td>
                    <td class="border border-gray-300 dark:border-gray-600 p-2"></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

</x-filament-panels::page>
