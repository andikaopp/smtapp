<x-filament-panels::page>
    <form wire:submit.prevent="submit" class="space-y-6">
        {{ $this->form }}
        <x-filament::button type="submit" color="primary" style="margin-top:10px; width:100%">
            Simpan
        </x-filament::button>
    </form>
</x-filament-panels::page>
