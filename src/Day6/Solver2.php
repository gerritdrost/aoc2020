<?php

namespace GerritDrost\AoC2020\Day6;

use DusanKasan\Knapsack\Collection;
use GerritDrost\AoC2020\Utils\Generators;
use GerritDrost\AoC2020\Solver;

class Solver2 implements Solver
{
    public function solve($inputHandle): int
    {
        $lineGroups = Generators::lineGroupsFromHandle($inputHandle);

        return Collection::from($lineGroups)
            /*
             * Every item is an array of strings. The array represents a group of persons, each string represents the
             * answers of one person.
             *
             * We map the array of strings to an array of arrays, so we have an array with letters for each person.
             *
             * For example:
             *   - ['abc', 'ab', 'acde'] => [['a', 'b', 'c'], ['a', 'b'], ['a', 'c', 'd', 'e']]
             *   - ['a', 'zzz'] => [['a'], ['z', 'z', 'z']]
             */
            ->map(fn(array $a) => array_map('str_split', $a))
            /*
             * Intersecting the to find the answers every person in the group had.
             */
            ->map(fn(array $a) => array_intersect(...$a))
            // Count and sum
            ->map(fn(array $a) => count($a))
            ->sum();
    }
}