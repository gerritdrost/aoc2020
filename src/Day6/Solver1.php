<?php

namespace GerritDrost\AoC2020\Day6;

use DusanKasan\Knapsack\Collection;
use GerritDrost\AoC2020\Utils\Generators;
use GerritDrost\AoC2020\Solver;

class Solver1 implements Solver
{
    public function solve($inputHandle): int
    {
        $lineGroups = linegroups_from_handle($inputHandle);

        return Collection::from($lineGroups)
            /*
             * Every item is an array of strings. The array represents a group of persons, each string represents the
             * answers of one person.
             *
             * We glue the strings of one group together, then separate them into an array of letters. This way we have
             * all answers of a group, as separate letters.
             *
             * For example:
             *   - ['abc', 'ab', 'acde'] => ['a', 'b', 'c', 'a', 'b', 'a', 'c', 'd', 'e']
             *   - ['a', 'zzz'] => ['a', 'z', 'z', 'z']
             */
            ->map(fn(array $a) => str_split(implode('', $a)))
            // Count unique values and sum
            ->map(fn(array $a) => count(array_unique($a)))
            ->sum();
    }
}