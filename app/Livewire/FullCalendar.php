<?php

namespace App\Livewire;

use Livewire\Component;
use Carbon\Carbon;

class FullCalendar extends Component
{
    public Carbon $currentDate;

    private array $monthTranslations = [
        1 => 'Enero',
        2 => 'Febrero',
        3 => 'Marzo',
        4 => 'Abril',
        5 => 'Mayo',
        6 => 'Junio',
        7 => 'Julio',
        8 => 'Agosto',
        9 => 'Septiembre',
        10 => 'Octubre',
        11 => 'Noviembre',
        12 => 'Diciembre'
    ];

    public function mount()
    {
        $this->currentDate = Carbon::now();
    }

    private function getTranslatedMonth(): string
    {
        $month = $this->monthTranslations[$this->currentDate->month];
        return $month . ' ' . $this->currentDate->year;
    }

    public function nextMonth()
    {
        $this->currentDate->addMonth();
    }

    public function previousMonth()
    {
        $this->currentDate->subMonth();
    }

    private function calculateRequiredRows(): int
    {
        $firstWeekday = $this->currentDate->copy()->firstOfMonth()->dayOfWeekIso - 1;
        $daysInMonth = $this->currentDate->daysInMonth;

        // Calculamos el total de días necesarios (días previos + días del mes)
        $totalDays = $firstWeekday + $daysInMonth;

        // Calculamos el número de filas necesarias redondeando hacia arriba
        return ceil($totalDays / 7);
    }

    public function selectDate($day)
    {
        if ($day > 0 && $day <= $this->currentDate->daysInMonth) {
            $this->selectedDate = $this->currentDate->copy()->setDay($day)->format('Y-m-d');
            $this->dispatch('show-clockin-modal', date: $this->selectedDate);
        }
    }

    public function render()
    {
        // Ajustamos el primer día de la semana (0-6, empezando en Lunes)
        $firstWeekday = $this->currentDate->copy()->firstOfMonth()->dayOfWeekIso - 1;

        return view('livewire.full-calendar', [
            'daysInMonth' => $this->currentDate->daysInMonth,
            'firstWeekday' => $firstWeekday,
            'monthName' => $this->getTranslatedMonth(),
            'requiredRows' => $this->calculateRequiredRows()
        ]);
    }
}
