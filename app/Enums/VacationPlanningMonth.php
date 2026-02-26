<?php

namespace App\Enums;

enum VacationPlanningMonth: string
{
    case January = 'Janeiro';
    case February = 'Fevereiro';
    case March = 'Março';
    case April = 'Abril';
    case May = 'Maio';
    case June = 'Junho';
    case July = 'Julho';
    case August = 'Agosto';
    case September = 'Setembro';
    case October = 'Outubro';
    case November = 'Novembro';
    case December = 'Dezembro';

    /**
     * @return list<string>
     */
    public static function values(): array
    {
        return array_map(static fn (self $case): string => $case->value, self::cases());
    }
}
