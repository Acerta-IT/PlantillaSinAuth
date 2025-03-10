<?php

namespace App\Livewire;

use App\Models\Holiday;
use Livewire\Component;
use Carbon\Carbon;

class LeaveSettings extends Component
{
    public $date = '';
    public $description = '';
    public $holidayToDelete = null;

    protected $rules = [
        'date' => 'required|date|unique:holidays,date',
        'description' => 'string|max:60',
    ];

    protected $messages = [
        'date.required' => 'La fecha es obligatoria',
        'date.date' => 'La fecha debe ser válida',
        'date.unique' => 'Ya existe un festivo en esta fecha',
    ];

    public function addHoliday()
    {
        $this->validate();

        Holiday::create([
            'date' => $this->date,
            'description' => $this->description,
        ]);

        $this->reset(['date', 'description']);
        $this->dispatch('close-modal', 'new-holiday-modal');
    }

    public function deleteHoliday($id)
    {
        Holiday::find($id)->delete();
    }

    public function render()
    {
        return view('livewire.leave-settings', [
            'holidays' => Holiday::orderBy('date')->get()
        ]);
    }
}
