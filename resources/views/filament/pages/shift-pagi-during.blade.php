<x-filament-panels::page>
    <form wire:submit.prevent="submit" class="space-y-6">
        {{ $this->form }}
        <x-filament::button type="submit" color="primary" style="margin-top:10px; width:100%">
            Simpan
        </x-filament::button>
    </form>
</x-filament-panels::page>
{{--<div class="p-6 bg-green-100 border border-green-400 text-green-700 rounded-lg shadow-md">--}}
{{--    <div class="flex items-center">--}}
{{--        <svg class="h-6 w-6 text-green-500 mr-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">--}}
{{--            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />--}}
{{--        </svg>--}}
{{--        <div>--}}
{{--            <h3 class="text-lg font-semibold">Shift Selesai Hari Ini!</h3>--}}
{{--            <p class="mt-1 text-sm">Anda sudah berhasil melakukan submit Checklist Shift Pagi untuk hari ini ({{ now()->translatedFormat('d F Y') }}). Terima kasih!</p>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
