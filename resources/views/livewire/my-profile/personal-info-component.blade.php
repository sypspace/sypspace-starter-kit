<form wire:submit.prevent="submit" class="pt-6 space-y-6">

    {{ $this->form }}

    <div class="text-right">
        <x-filament::button type="submit" form="submit" class="align-right">
            {{ __('filament-breezy::default.profile.personal_info.submit.label') }}
        </x-filament::button>
    </div>
</form>
