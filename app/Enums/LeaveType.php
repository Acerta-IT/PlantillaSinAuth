<?php

namespace App\enums;

enum LeaveType: string
{
    case VACATION = 'vacation';
    case MEDICAL_APPOINTMENT = 'appointment';
    case MEDICAL_LEAVE = 'medical';
    case SICK = 'sick';
    case FAMILY_HOSPITALIZATION = 'family';
    case PARENTAL = 'parental';
    case PERSONAL = 'personal';
    case MOVE = 'move';
    case MARRIAGE = 'marriage';
    case FAMILY_MARRIAGE = 'family_marriage';
    case FAMILY_DEATH = 'family_death';
    case BIRTHDAY = 'birthday';
    case OTHER = 'other';

    public function label(): string
    {
        return match($this) {
            self::VACATION => 'Vacaciones',
            self::MEDICAL_APPOINTMENT => 'Cita médica',
            self::MEDICAL_LEAVE => 'Baja médica',
            self::SICK => 'Enfermedad',
            self::FAMILY_HOSPITALIZATION => 'Hospitalización familiar 2º grado',
            self::PARENTAL => 'Maternidad / Paternidad',
            self::PERSONAL => 'Asuntos propios',
            self::MOVE => 'Mudanza',
            self::MARRIAGE => 'Matrimonio',
            self::FAMILY_MARRIAGE => 'Matrimonio familiar 2º grado',
            self::FAMILY_DEATH => 'Fallecimiento familiar 1er grado',
            self::BIRTHDAY => 'Cumpleaños',
            self::OTHER => 'Otro',
        };
    }

    public function maxDays(): ?int
    {
        return match($this) {
            self::FAMILY_HOSPITALIZATION => 3,
            self::MOVE => 2,
            self::MARRIAGE => 15,
            self::FAMILY_MARRIAGE => 1,
            self::FAMILY_DEATH => 4,
            self::BIRTHDAY => 1,
            self::PARENTAL => 64,
            self::VACATION, self::MEDICAL_LEAVE, self::OTHER => null, // No limit
            self::MEDICAL_APPOINTMENT, self::PERSONAL, self::SICK => null, // No limit
        };
    }

    public function requiresJustification(): bool
    {
        return match($this) {
            self::FAMILY_HOSPITALIZATION, self::MEDICAL_APPOINTMENT, self::PARENTAL, self::MOVE => true,
            self::MARRIAGE, self::FAMILY_MARRIAGE, self::FAMILY_DEATH => true,
            default => false,
        };
    }

    public static function toArray(): array
    {
        return collect(self::cases())->map(fn($type) => [
            'value' => $type->value,
            'label' => $type->label(),
            'maxDays' => $type->maxDays(),
            'requiresJustification' => $type->requiresJustification(),
        ])->toArray();
    }
}
