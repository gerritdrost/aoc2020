<?php

namespace GerritDrost\AoC2020\Day3;

use DusanKasan\Knapsack\Collection;
use GerritDrost\AoC2020\Utils\Arrays;
use GerritDrost\AoC2020\Solver;

class Solver2 implements Solver
{
    public function solve($inputHandle): int
    {
        $lines = iterator_to_array(lines_from_handle($inputHandle));
        $width = strlen($lines[0]);

        $treeProduct = 1;
        $steps = [[1, 1], [3, 1], [5, 1], [7, 1], [1, 2]];
        foreach ($steps as $step) {
            [$dx, $dy] = $step;

            $treeCount = Collection
                ::from($lines)
                ->filter(fn ($_, $y) => $y % $dy === 0)
                ->indexBy(fn ($_, $y) => $y / $dy)
                ->map(fn($line, $y) => substr($line, ($y * $dx) % $width, 1))
                ->filter(fn (string $char) => $char === '#')
                ->size();

            $treeProduct *= $treeCount;
        }

        return $treeProduct;
    }
}