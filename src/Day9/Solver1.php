<?php

namespace GerritDrost\AoC2020\Day9;

use DusanKasan\Knapsack\Collection;
use GerritDrost\AoC2020\Solver;
use GerritDrost\AoC2020\Utils\Arrays;
use InvalidArgumentException;

class Solver1 implements Solver
{
    public function __construct(private int $preambleSize = 25)
    {
    }

    /**
     * @param int[]|resource $input
     *
     * @return int
     */
    public function solve($input): int
    {
        if (is_resource($input)) {
            $ints = Arrays::intLinesFromHandle($input);
        } elseif (is_array($input)) {
            $ints = $input;
        } else {
            throw new InvalidArgumentException("Expected parameter \$input to be either an array or a handle");
        }

        /*
         * Provided an array of integers, computes an array of unique sums of all pairs from the array provided.
         */
        $sumsMapper = function (Collection $lastNumberCollection) {
            $lastNums = $lastNumberCollection->values()->toArray();
            $size     = count($lastNums);

            $products = [];
            for ($i = 0; $i < ($size - 1); $i++) {
                for ($j = $i + 1; $j < $size; $j++) {
                    $products[] = $lastNums[$i] + $lastNums[$j];
                }
            }

            return array_unique($products);
        };

        $lastNumberSums = Collection::from($ints)
            ->partition($this->preambleSize, 1)
            ->map($sumsMapper);

        $numbersWithoutPreamble = Collection
            ::from($ints)
            ->drop($this->preambleSize);

        return $numbersWithoutPreamble
            ->zip($lastNumberSums)
            ->map(fn (Collection $pair) => $pair->values()->toArray())
            ->dropWhile(fn ($pair) => in_array($pair[0], $pair[1], true))
            ->map(fn ($pair) => $pair[0])
            ->first();
    }
}