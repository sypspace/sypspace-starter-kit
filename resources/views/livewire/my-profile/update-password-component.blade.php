
<form wire:submit.prevent="submit" class="pt-6 space-y-6">
    <x-filament::section aside>
        <x-slot name="heading">
            Security
        </x-slot>
    
        <x-slot name="description">
            {{ __('filament-breezy::default.profile.password.subheading') }}
        </x-slot>

        {{ $this->form }}

    </x-filament::section>

    <div class="text-right">
        <x-filament::button type="submit" form="submit" class="align-right">
            {{ __('filament-breezy::default.profile.password.submit.label') }}
        </x-filament::button>
    </div>
</form>