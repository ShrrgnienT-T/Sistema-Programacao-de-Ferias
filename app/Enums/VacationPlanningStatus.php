<?php

namespace App\Enums;

enum VacationPlanningStatus: string
{
    case Pending = 'Pendente';
    case InReview = 'Em Análise';
    case Approved = 'Aprovada';

    /**
     * @return list<string>
     */
    public static function values(): array
    {
        return array_map(static fn (self $case): string => $case->value, self::cases());
    }
}
