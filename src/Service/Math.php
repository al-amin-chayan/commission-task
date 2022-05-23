<?php

declare(strict_types=1);

namespace App\Service;

class Math
{
    /**
     * Round float value up supporting decimal precision.
     */
    public static function ceil(float $value, int $precision = 2): float
    {
        $pow = pow(10, $precision);

        return (ceil($pow * $value) + ceil($pow * $value - ceil($pow * $value))) / $pow;
    }
}
