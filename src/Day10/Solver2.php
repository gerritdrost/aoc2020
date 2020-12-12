<?php

namespace GerritDrost\AoC2020\Day10;

use DusanKasan\Knapsack\Collection;
use GerritDrost\AoC2020\Solver;
use MathPHP\LinearAlgebra\Matrix;

class Solver2 implements Solver
{
    public function solve($inputHandle): int
    {
        $adapters = iterator_to_array(int_lines_from_handle($inputHandle));
        sort($adapters);

        // Add the socket and the internal adapter
        $joltages = [0, ...$adapters, end($adapters) + 3];

        // We need this a lot
        $N = count($joltages);

        // Empty adjacency matrix row
        $emptyMatrixRow  = Collection::from($joltages)->flip()->map(fn ($_) => 0);
        $adjacencyMatrix = new Matrix(
            Collection::from($joltages)
                //
                // Create windows from current position of max size 4.
                ->map(fn (int $j, int $i) => Collection::from($joltages)->slice($i, min($N, $i + 4)))
                //
                // First joltage in slice becomes key, rest become values.
                ->indexBy(fn ($v) => $v->first())
                ->map(fn ($v) => $v->slice(1))
                //
                // Discard the joltages that are out of range of the key joltage.
                ->map(fn ($v, $j1) => $v->filter(fn ($j) => $j > $j1 && $j <= $j1 + 3))
                //
                // Flip the list of adjacent joltages into a map, and set the values to 1.
                ->map(fn ($v) => $v->flip()->map(fn ($_) => 1))
                //
                // Paste our map over a map containing 0 for all adapters. This gives us an adjacency matrix row.
                ->map(fn ($v) => $emptyMatrixRow->replaceByKeys($v))
                //
                // -> 2D array for Matrix-class
                ->map(fn ($v) => $v->values()->toArray())
                ->values()
                ->toArray()
        );

        $result = 0;
        $matrix = $adjacencyMatrix;
        for ($i = 0; $i < $N; $i++) {
            $matrix = $matrix->multiply($adjacencyMatrix);
            $result += $matrix->get(0, $N - 1);
        }

        return $result;
    }
}