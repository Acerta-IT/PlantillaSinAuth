@props(['leave'])

@use(App\Enums\LeaveType)
@use(App\Enums\LeaveStatus)

<div class="bg-white overflow-hidden border border-gray-200 rounded-md">
    <div class="p-6">
        <div class="grid grid-cols-12 gap-y-2">
            <div class="col-span-9">
                <h3 class="text-lg font-semibold text-gray-900">
                    {{ LeaveType::from($leave->type)->label() }}
                </h3>
            </div>
            <div class="col-span-3 flex justify-end items-start">
                @php
                    $status = LeaveStatus::from($leave->status);
                    $statusClasses = match($status) {
                        LeaveStatus::PENDING => 'bg-yellow-100 text-yellow-800',
                        LeaveStatus::APPROVED => 'bg-green-100 text-green-800',
                        LeaveStatus::REJECTED => 'bg-red-100 text-red-800',
                    };
                @endphp
                <span class="inline-block px-3 py-1 text-xs font-medium rounded-md {{ $statusClasses }}">
                    {{ $status->label() }}
                </span>
            </div>
            <div class="col-span-9 flex items-center gap-2">
                <span class="text-gray-500">📅</span>
                <span class="text-sm text-gray-600">
                    @if($leave->start_date === $leave->end_date)
                        {{ \Carbon\Carbon::parse($leave->start_date)->format('d/m/Y') }}
                    @else
                        {{ \Carbon\Carbon::parse($leave->start_date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($leave->end_date)->format('d/m/Y') }}
                    @endif
                </span>
            </div>
            <div class="col-span-3 flex justify-end mr-1">
                <span class="text-sm text-gray-600">{{ $leave->days }} {{ Str::of('día')->plural($leave->days) }}</span>
            </div>
        </div>

        @if($leave->comments)
            <div class="mt-4">
                <p class="text-sm text-gray-600">{{ $leave->comments }}</p>
            </div>
        @endif

        @if($leave->justification_file_path)
            <div class="mt-4">
                {{-- <a href="#" class="inline-flex items-center text-sm text-blue-600 hover:underline">
                    <span class="material-symbols-outlined text-xl mr-1">download</span>
                    Descargar justificante
                </a> --}}
                <x-icon-text-button icon="download">
                    Descargar justificante
                </x-icon-text-button>
            </div>
        @elseif(LeaveType::from($leave->type)->requiresJustification() && $leave->justification_file_path === null)
            <div class="mt-4">
                <span class="text-sm text-red-600">El justificante es obligatorio</span>
            </div>
        @endif
    </div>
</div>
