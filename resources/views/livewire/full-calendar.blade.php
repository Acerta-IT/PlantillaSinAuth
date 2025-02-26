<div class="w-full p-4 px-10 2xl:px-24">
    <!-- Encabezado del calendario -->
    <div class="flex justify-between items-center my-4">
        <div class="flex justify-center items-center">
            <x-icon-button wire:click="previousMonth" icon="chevron_left"></x-icon-button>
            <h2 class="w-48 text-lg font-semibold text-center">{{ $monthName }}</h2>
            <x-icon-button wire:click="nextMonth" icon="chevron_right"></x-icon-button>
        </div>

        <div>
            {{-- Clockin in large screens --}}
            <div class="hidden 2xl:flex gap-4 justify-center items-center  ">
                <x-link-button>Iniciar jornada</x-link-button>
                00:00
                <x-link-button type="warning" text="black">Iniciar descanso</x-link-button>
                00:00
            </div>

            {{-- Clockin in small screens --}}
            <div class="flex gap-4 justify-center items-center 2xl:hidden">
                <x-icon-button icon="play_circle">Iniciar jornada</x-link-button>
                    00:00
                    <x-icon-button icon="pause_circle" type="warning" text="black">Iniciar descanso</x-link-button>
                        00:00
            </div>
        </div>
    </div>

    <!-- Tabla del calendario -->
    <div class="rounded-md border border-gray-300 overflow-hidden">
        <table class="w-full border-collapse table-fixed">
            <!-- Días de la semana -->
            <thead>
                <tr class="">
                    <th class="border-b border-r border-gray-300 w-[14.28%]">Lun</th>
                    <th class="border-b border-r border-gray-300 w-[14.28%]">Mar</th>
                    <th class="border-b border-r border-gray-300 w-[14.28%]">Mié</th>
                    <th class="border-b border-r border-gray-300 w-[14.28%]">Jue</th>
                    <th class="border-b border-r border-gray-300 w-[14.28%]">Vie</th>
                    <th class="border-b border-r border-gray-300 w-[14.28%]">Sáb</th>
                    <th class="border-b border-gray-300 w-[14.28%]">Dom</th>
                </tr>
            </thead>
            <tbody>
                @for ($row = 0; $row < $requiredRows; $row++)
                    <tr>
                        @for ($column = 0; $column < 7; $column++)
                            @php
                                $day = $row * 7 + $column - $firstWeekday + 1;
                                $isToday =
                                    $day == now()->day &&
                                    $currentDate->isCurrentMonth() &&
                                    $currentDate->isCurrentYear();
                                $isLastRow = $row === $requiredRows - 1;
                            @endphp
                            <td class="h-20 2xl:h-24 p-0 relative border-r border-gray-300 hover:bg-gray-50 cursor-pointer last:border-r-0 {{ !$isLastRow ? 'border-b' : '' }}"
                                @if ($day > 0 && $day <= $daysInMonth) data-modal-target="clockin-modal"
                                    data-modal-toggle="clockin-modal"
                                    onclick="document.getElementById('date').value = '{{ $currentDate->copy()->setDay($day)->format('Y-m-d') }}'" @endif>
                                @if ($day > 0 && $day <= $daysInMonth)
                                    <span
                                        class="absolute text-sm font-semibold
                                        {{ $isToday
                                            ? 'bg-blue-500 text-white w-6 h-6 flex items-center justify-center rounded-full left-1 top-1'
                                            : 'left-1 top-1' }}">
                                        {{ $day }}
                                    </span>
                                @else
                                    <div class="h-full w-full bg-gray-100"></div>
                                @endif
                                @if ($isToday)
                                    <x-clockin-info />
                                @endif
                            </td>
                        @endfor
                    </tr>
                @endfor
            </tbody>
        </table>
    </div>
</div>
