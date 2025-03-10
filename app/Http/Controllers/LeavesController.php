<?php

namespace App\Http\Controllers;

use App\Enums\LeaveType;
use App\Enums\LeaveStatus;
use App\Models\Leave;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LeavesController extends Controller
{
    public function index()
    {
        // Create example leaves for testing the UI
        $pendingLeaves = collect([
            new Leave([
                'type' => LeaveType::VACATION->value,
                'start_date' => Carbon::now()->addDays(5),
                'end_date' => Carbon::now()->addDays(10),
                'status' => LeaveStatus::APPROVED->value,
                'days' => 6,
                'comments' => 'Vacaciones de verano',
            ]),
            new Leave([
                'type' => LeaveType::SICK->value,
                'start_date' => Carbon::tomorrow(),
                'end_date' => Carbon::tomorrow(),
                'status' => LeaveStatus::PENDING->value,
                'days' => 1,
                'comments' => 'Cita médica',
                'justification_file_path' => 'path/to/justification.pdf',
            ]),
            new Leave([
                'type' => LeaveType::PERSONAL->value,
                'start_date' => Carbon::now()->addDays(15),
                'end_date' => Carbon::now()->addDays(15),
                'status' => LeaveStatus::REJECTED->value,
                'days' => 1,
                'comments' => 'Asuntos propios',
            ]),
            new Leave([
                'type' => LeaveType::FAMILY_DEATH->value,
                'start_date' => Carbon::now()->addDays(12),
                'end_date' => Carbon::now()->addDays(15),
                'status' => LeaveStatus::REJECTED->value,
                'days' => 4,
                'comments' => LeaveType::FAMILY_DEATH->label(),
            ]),
            new Leave([
                'type' => LeaveType::FAMILY_HOSPITALIZATION->value,
                'start_date' => Carbon::tomorrow(),
                'end_date' => Carbon::tomorrow(),
                'status' => LeaveStatus::PENDING->value,
                'days' => 1,
            ]),
        ]);

        return view('leaves.index', [
            'pendingLeaves' => $pendingLeaves
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => ['required', 'string', 'in:' . implode(',', array_column(LeaveType::toArray(), 'value'))],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'comments' => ['nullable', 'string', 'max:500'],
        ], [
            'type.required' => 'El tipo de ausencia es obligatorio',
            'type.in' => 'El tipo de ausencia seleccionado no es válido',
            'start_date.required' => 'La fecha de inicio es obligatoria',
            'start_date.date' => 'La fecha de inicio debe ser una fecha válida',
            'end_date.required' => 'La fecha de fin es obligatoria',
            'end_date.date' => 'La fecha de fin debe ser una fecha válida',
            'end_date.after_or_equal' => 'La fecha de fin debe ser posterior o igual a la fecha de inicio',
        ]);

        // If validation passes, continue with storing the leave request
        // ... your storage logic here
    }
}
