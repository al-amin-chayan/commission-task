<?php

declare(strict_types=1);

namespace Tests\Service;

use PHPUnit\Framework\TestCase;
use App\Service\Math;

class MathTest extends TestCase
{
    /**
     * @test
     *
     * @param float $value
     * @param int $precision
     * @param float $expectation
     *
     * @dataProvider roundUpCases
     */
    public function it_will_round_up_float_value_up(float $value, int $precision, float $expectation)
    {
        $this->assertEquals(
            $expectation,
            Math::ceil($value, $precision)
        );
    }

    public function roundUpCases(): array
    {
        return [
            'round up to integer point' => [2.03, 0, 3],
            'round upto 1 decimal point' => [2.03, 1, 2.1],
            'round upto 2 decimal point' => [0.023, 2, 0.03],
        ];
    }
}
