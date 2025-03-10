<x-app-layout>
    <x-slot name="header">
        Ausencias
    </x-slot>

    <div class="py-12">
        <div class="sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-md sm:rounded-lg mb-8">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold">Ausencias pendientes</h2>
                        <x-link-button type="primary" x-data="" x-on:click="$dispatch('open-modal', 'new-leave-modal')">
                            Nueva ausencia
                        </x-link-button>
                    </div>

                    @if($pendingLeaves->isEmpty())
                        <p class="text-gray-500 text-sm">No hay ausencias pendientes</p>
                    @else
                        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                            @foreach($pendingLeaves as $leave)
                                <x-leave :leave="$leave" />
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-xl font-semibold mb-4">Historial de Ausencias</h2>
                    <p class="text-gray-500 text-sm">No hay ausencias en el historial</p>
                </div>
            </div>
        </div>
    </div>

    <x-modal-center name="new-leave-modal" :show="false" maxWidth="xl">
        <livewire:new-leave-form />
    </x-modal-center>
</x-app-layout>
