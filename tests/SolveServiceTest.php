<?php

use GerritDrost\AoC2020\SolveService;
use PHPUnit\Framework\TestCase;

class SolveServiceTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testSolve(int $day, int $part, int $expected)
    {
        $this->assertEquals($expected, SolveService::solve($day, $part));
    }

    public function dataProvider(): array
    {
        return [
            '1.1' => [1, 1, 1006875],
            '1.2' => [1, 2, 165026160],
            '2.1' => [2, 1, 542],
            '2.2' => [2, 2, 360],
            '3.1' => [3, 1, 211],
            '3.2' => [3, 2, 3584591857],
            '4.1' => [4, 1, 204],
            '4.2' => [4, 2, 179],
            '5.1' => [5, 1, 861],
            '5.2' => [5, 2, 633],
            '6.1' => [6, 1, 6947],
            '6.2' => [6, 2, 3398],
            '7.1' => [7, 1, 229],
            '7.2' => [7, 2, 6683],
            '8.1' => [8, 1, 1941],
            '8.2' => [8, 2, 2096],
            '9.1' => [9, 1, 138879426],
            '9.2' => [9, 2, 23761694],
            '10.1' =>  [10, 1, 2201],
            '10.2' => [10, 2, 169255295254528],
            '11.1' => [11, 1, 2338],
            '11.2' => [11, 2, 2134],
        ];
    }
}