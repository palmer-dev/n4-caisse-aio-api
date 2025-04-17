<x-filament-widgets::widget>
    <x-filament::section>
        {{-- Widget content --}}
        <div class="text-xl font-bold text-gray-800 flex items-center gap-3">
            <x-heroicon-c-building-storefront class="w-10 h-10"/>
            <span>Votre magasin : {{ auth()->user()->shop->name }}</span>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
