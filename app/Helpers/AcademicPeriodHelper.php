<?php

namespace App\Helpers;

use App\Models\AcademicPeriod;

class AcademicPeriodHelper
{
    /**
     * Generate academic period name
     * @param AcademicPeriod $academicPeriod
     * @return string
     */
    public static function formatName (AcademicPeriod $academicPeriod): string
    {
        $startMonth = self::generateMonth($academicPeriod->start_month);
        $endMonth = self::generateMonth($academicPeriod->end_month);
        $periodName = "{$academicPeriod->type} {$startMonth} {$academicPeriod->start_year} - {$endMonth} {$academicPeriod->end_year}";

        return $periodName;
    }

    /**
     * Generate month string
     * @param int $monthNumber
     * @return string
     */
    public static function generateMonth (int $monthNumber): string
    {
        $months = [
            1 => 'ENERO',
            2 => 'FEBRERO',
            3 => 'MARZO',
            4 => 'ABRIL',
            5 => 'MAYO',
            6 => 'JUNIO',
            7 => 'JULIO',
            8 => 'AGOSTO',
            9 => 'SEPTIEMBRE',
            10 => 'OCTUBRE',
            11 => 'NOVIEMBRE',
            12 => 'DICIEMBRE'
        ];

        return $months[$monthNumber];
    }
}