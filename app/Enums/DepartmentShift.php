<?php

namespace App\Enums;

enum DepartmentShift: string
{
    case SixByOne = '6x1';
    case Management = 'Gestão';
    case Admin = 'Adm';
    case DayEven = 'Diurno Par';
    case DayOdd = 'Diurno Impar';
    case NightEven = 'Noturno Par';
    case NightOdd = 'Noturno Impar';
    case Unassigned = 'Sem Departamento';

    /**
     * @return list<string>
     */
    public static function values(): array
    {
        return array_map(static fn (self $case): string => $case->value, self::cases());
    }
}
