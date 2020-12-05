<?php

namespace GerritDrost\AoC2020\Day3;

use DusanKasan\Knapsack\Collection;
use GerritDrost\AoC2020\Utils\Arrays;
use GerritDrost\AoC2020\Solver;

class Solver1 implements Solver
{
    public function solve($inputHandle): int
    {
        $lines = Arrays::linesFromHandle($inputHandle);
        $width = strlen($lines[0]);

        return Collection
            ::from($lines)
            ->map(fn($line, $y) => substr($line, ($y * 3) % $width, 1))
            ->filter(fn (string $char) => $char === '#')
            ->size();
    }
}