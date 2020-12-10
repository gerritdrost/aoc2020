<?php

namespace GerritDrost\AoC2020\Day10;

use DusanKasan\Knapsack\Collection;
use GerritDrost\AoC2020\Solver;
use GerritDrost\AoC2020\Utils\Arrays;

class Solver1 implements Solver
{
    public function solve($inputHandle): int
    {
        $adapters = Arrays::intLinesFromHandle($inputHandle);
        sort($adapters);

        return Collection::from($adapters)
            ->prepend(0)
            ->append(max($adapters) + 3)
            ->partition(2, 1)
            ->map(fn(Collection $pair) => $pair->second() - $pair->first())
            ->frequencies()
            ->only([1, 3])
            ->reduce(fn ($r, $n) => $r * $n, 1);
    }
}