<?php

namespace GerritDrost\AoC2020\Day9;

use DusanKasan\Knapsack\Collection;
use GerritDrost\AoC2020\Solver;
use GerritDrost\AoC2020\Utils\Arrays;

class Solver1 implements Solver
{
    public function solve($inputHandle): int
    {
        $ints         = Arrays::intLinesFromHandle($inputHandle);
        $preambleSize = 25;

        $lastNumberSums = Collection::from($ints)
            ->partition($preambleSize, 1)
            ->map(fn (Collection $nums) => Utils::computeSums($nums->values()->toArray()))
            ->realize();

        $numbersWithoutPreamble = Collection
            ::from($ints)
            ->drop($preambleSize)
            ->realize();

        return $numbersWithoutPreamble
            ->zip($lastNumberSums)
            ->map(fn (Collection $pair) => $pair->values()->toArray())
            ->dropWhile(fn ($pair) => in_array($pair[0], $pair[1], true))
            ->map(fn ($pair) => $pair[0])
            ->first();
    }
}