<?php

namespace App\Enums;

enum EmployeeJobTitle: string
{
    case Asg = 'ASG';
    case Collector = 'COLETOR';
    case Housekeeping = 'ROUPARIA';
    case Supervisor = 'ENCARREGADA';
    case HrAnalyst = 'Analista de RH';
    case Analyst = 'Analista';
    case Coordinator = 'Coordenador';

    /**
     * @return list<string>
     */
    public static function values(): array
    {
        return array_map(static fn (self $case): string => $case->value, self::cases());
    }

    public function label(): string
    {
        return $this->value;
    }
}
