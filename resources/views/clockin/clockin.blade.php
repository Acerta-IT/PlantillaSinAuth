<x-app-layout>
    <x-slot name="header">
        Fichajes
    </x-slot>

    <div class="flex flex-col justify-center items-center">

        @livewire('full-calendar')
    </div>

    @livewire('clockin-modal')
</x-app-layout>
