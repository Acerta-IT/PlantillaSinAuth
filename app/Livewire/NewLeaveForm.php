<?php

namespace App\Livewire;

use App\Enums\LeaveType;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Leave;
use App\Models\Holiday;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Services\WorkingDaysCalculator;

class NewLeaveForm extends Component
{
    use WithFileUploads;

    public $type = '';
    public $start_date = '';
    public $end_date = '';
    public $comments = '';
    public $calculatedDays = 0;
    // This is the file object from the Livewire Dropzone component
    // Repository: https://github.com/dasundev/livewire-dropzone?ref=madewithlaravel.com
    // How to use: https://www.dasun.dev/blog/how-to-use-livewire-dropzone#:~:text=The%20Livewire%20Dropzone%20component%20makes,must%20have%20Livewire%203%20installed.
    /* [▼
        "tmpFilename" => "oRF24GPFR0i8rIntTmYGHJNFQH627U-metaRnJhbWUgMi5wbmc=-.png"
        "name" => "Frame 2.png"
        "extension" => "png"
        "path" => "C:\Repositories\Fichaje\storage\app/private\livewire-tmp/oRF24GPFR0i8rIntTmYGHJNFQH627U-metaRnJhbWUgMi5wbmc=-.png"
        "temporaryUrl" => "http://127.0.0.1:8000/livewire/preview-file/oRF24GPFR0i8rIntTmYGHJNFQH627U-metaRnJhbWUgMi5wbmc=-.png?expires=1740743999&signature=9b9aabbb7d2f3025a708efe885c13c ▶"
        "size" => 234168
    ] */
    public $justification_file = null;

    protected function rules()
    {
        $rules = [
            'type' => ['required', 'string', 'in:' . implode(',', array_column(LeaveType::toArray(), 'value'))],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'comments' => ['nullable', 'string', 'max:500'],
        ];

        return $rules;
    }

    protected $messages = [
        'type.required' => 'El tipo de ausencia es obligatorio',
        'type.in' => 'El tipo de ausencia seleccionado no es válido',
        'start_date.required' => 'La fecha de inicio es obligatoria',
        'start_date.date' => 'La fecha de inicio debe ser una fecha válida',
        'end_date.required' => 'La fecha de fin es obligatoria',
        'end_date.date' => 'La fecha de fin debe ser una fecha válida',
        'end_date.after_or_equal' => 'La fecha de fin debe ser posterior o igual a la fecha de inicio',
    ];

    public function updatedType()
    {
        if ($this->type && !LeaveType::from($this->type)->requiresJustification()) {
            $this->justification_file = null;
        }
    }

    public function calculateDays()
    {
        if ($this->start_date && $this->end_date) {
            $calculator = app(WorkingDaysCalculator::class);
            $this->calculatedDays = $calculator->calculate($this->start_date, $this->end_date);
        }
    }

    public function submit()
    {
        $this->validate();

        // Store file if provided
        $justificationPath = $this->storeJustificationFile();

        // Create leave request
        /* $leave = Leave::create([
            'type' => $this->type,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'comments' => $this->comments,
            'justification_file_path' => $justificationPath,
            'status' => 'pending',
            'user_id' => '123'
        ]); */

        $this->reset();
        $this->dispatch('close');
    }

    public function storeJustificationFile()
    {
        if (!$this->justification_file) {
            return null;
        }

        // Ensure directory exists
        Storage::makeDirectory('private/justification_files');

        // Generate unique filename
        $uuid = Str::uuid();

        // Get the first file from the array
        $file = is_array($this->justification_file) ? $this->justification_file[0] : $this->justification_file;

        // Get extension directly from the array
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = $uuid . '.' . $extension;  // Note the spaces around the dots

        // Move the file from the temporary location to the final location
        $path = Storage::putFileAs(
            'justification_files',
            $file['path'],
            $filename
        );

        return $path; // Returns relative path for database storage
    }

    public function render()
    {
        $selectedType = $this->type ? LeaveType::from($this->type) : null;

        # test leave objects

        return view('livewire.new-leave-form', [
            'leaveTypes' => LeaveType::toArray(),
            'requiresJustification' => $selectedType?->requiresJustification() ?? false,
        ]);
    }
}
