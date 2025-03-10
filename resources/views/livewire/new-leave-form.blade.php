<div class="p-12 py-8">
    <h2 class="text-lg font-semibold text-gray-900 mb-4">
        Nueva Ausencia
    </h2>

    <form wire:submit="submit" class="space-y-4">
        <div>
            <label for="type" class="block mb-2 text-sm font-medium text-gray-900">
                Tipo de ausencia
            </label>
            <select id="type" wire:model.live="type"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                <option value="">Seleccionar tipo</option>
                @foreach($leaveTypes as $type)
                    <option value="{{ $type['value'] }}">{{ $type['label'] }}</option>
                @endforeach
            </select>
            @error('type')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
        </div>

        @if($requiresJustification)
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900">
                    Justificante
                </label>
                <livewire:dropzone
                    wire:model="justification_file"
                    :multiple="false"
                    :max-files="1"
                    :rules="['mimes:pdf,jpg,jpeg,png', 'max:4096']"
                />
                @error('justification_file')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>
        @endif

        <div>
            <label for="start_date" class="block mb-2 text-sm font-medium text-gray-900">Fecha inicio</label>
            <input type="date" id="start_date" wire:model.live="start_date" wire:change="calculateDays"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            @error('start_date')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="end_date" class="block mb-2 text-sm font-medium text-gray-900">Fecha fin</label>
            <input type="date" id="end_date" wire:model.live="end_date" wire:change="calculateDays"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            @error('end_date')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
        </div>

        @if($start_date && $end_date)
            <div>
                <p class="text-sm font-medium text-gray-900">Días gastados: {{ $calculatedDays }}</p>
            </div>
        @endif

        <div>
            <label for="comments" class="block mb-2 text-sm font-medium text-gray-900">Comentarios</label>
            <textarea id="comments" wire:model="comments" rows="4"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"></textarea>
            @error('comments')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex pt-4 justify-end gap-4">
            <x-secondary-button x-on:click="$dispatch('close')">
                Cancelar
            </x-secondary-button>
            <x-primary-button type="submit">
                Solicitar ausencia
            </x-primary-button>
        </div>
    </form>
</div>
