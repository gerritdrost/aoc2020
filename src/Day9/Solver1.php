<?php

namespace GerritDrost\AoC2020\Day9;

use DusanKasan\Knapsack\Collection;
use GerritDrost\AoC2020\Solver;
use GerritDrost\AoC2020\Utils\Arrays;
use InvalidArgumentException;

class Solver1 implements Solver
{
    public function __construct(private int $preambleSize = 25) { }

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

        $lastNumberSums = Collection::from($ints)
            ->partition($this->preambleSize, 1)
            ->map(fn (Collection $nums) => Utils::computeSums($nums->values()->toArray()))
            ->realize();

        $numbersWithoutPreamble = Collection
            ::from($ints)
            ->drop($this->preambleSize)
            ->realize();

        return $numbersWithoutPreamble
            ->zip($lastNumberSums)
            ->map(fn (Collection $pair) => $pair->values()->toArray())
            ->dropWhile(fn ($pair) => in_array($pair[0], $pair[1], true))
            ->map(fn ($pair) => $pair[0])
            ->first();
    }
}