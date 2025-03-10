<div class="space-y-6">
    <div class="p-6 pt-0">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium text-gray-900">Días festivos</h3>
            <x-primary-button type="button" x-data="" x-on:click="$dispatch('open-modal', 'new-holiday-modal')">
                Añadir festivo
            </x-primary-button>
        </div>

        @if($holidays->isEmpty())
            <p class="text-gray-500 text-sm">No hay festivos configurados</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($holidays as $holiday)
                    <div class="flex items-center gap-4 max-w-md">
                        <p class="text-sm font-medium text-gray-900 w-24">
                            {{ Carbon\Carbon::parse($holiday->date)->format('d/m/Y') }}
                        </p>
                        <p class="text-sm text-gray-600 flex-1">{{ $holiday->description }}</p>
                        <button wire:click="$set('holidayToDelete', {{ $holiday->id }})" x-data="" x-on:click="$dispatch('open-modal', 'delete-holiday-modal')"
                            class="text-red-600 hover:text-red-900">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <x-modal-center name="new-holiday-modal" :show="false" maxWidth="md" x-data>
        <form wire:submit.prevent="addHoliday" class="p-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">
                Añadir nuevo festivo
            </h2>

            <p class="text-sm text-gray-600 mb-4">
                Añadir un festivo sí afectará a las vacaciones ya aprobadas.
            </p>

            <div class="space-y-4">
                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700">Fecha</label>
                    <input type="date" wire:model="date" id="date"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    @error('date')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Descripción</label>
                    <input type="text" wire:model="description" id="description"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    @error('description')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-4">
                <x-secondary-button type="button" x-on:click="$dispatch('close')">
                    Cancelar
                </x-secondary-button>
                <x-primary-button type="submit">
                    Guardar
                </x-primary-button>
            </div>
        </form>
    </x-modal-center>

    <x-modal-center name="delete-holiday-modal" :show="false" maxWidth="sm">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">
                Eliminar festivo
            </h2>
            <p class="text-sm text-gray-600 mb-4">
                ¿Estás seguro de que quieres eliminar este festivo?
            </p>
            <div class="mt-6 flex justify-end gap-4">
                <x-secondary-button type="button" x-on:click="$dispatch('close')">
                    Cancelar
                </x-secondary-button>
                <x-danger-button type="button" wire:click="deleteHoliday({{ $holidayToDelete }})" x-on:click="$dispatch('close')">
                    Eliminar
                </x-danger-button>
            </div>
        </div>
    </x-modal-center>
</div>
