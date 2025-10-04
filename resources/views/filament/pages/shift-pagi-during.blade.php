<x-filament-panels::page>
    <h2 class="text-2xl font-semibold mb-4">Shift Pagi - During Shift</h2>
    <p>Halaman ini digunakan untuk checklist kegiatan selama shift pagi dimulai.</p>
    <form wire:submit.prevent="submit" class="space-y-6">
        {{ $this->form }}
        <x-filament::button type="submit" color="primary">
            Simpan
        </x-filament::button>
    </form>
</x-filament-panels::page>
