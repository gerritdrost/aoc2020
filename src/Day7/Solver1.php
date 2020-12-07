<?php

namespace GerritDrost\AoC2020\Day7;

use DusanKasan\Knapsack\Collection;
use GerritDrost\AoC2020\Utils\Arrays;
use GerritDrost\AoC2020\Solver;

class Solver1 implements Solver
{
    public function solve($inputHandle): int
    {
        $lines = Arrays::linesFromHandle($inputHandle);

        $result = [];
        $stack  = ['shiny gold'];
        while (!empty($stack)) {
            $description     = array_pop($stack);
            $validContainers = $this->validContainers($lines, $description);

            $newContainers = array_diff($validContainers, $result);
            foreach ($newContainers as $newContainer) {
                array_push($stack, $newContainer);
                $result[] = $newContainer;
            }
        }

        return count($result);
    }

    private function validContainers(array $rules, string $description): array
    {
        return Collection::from($rules)
            ->map(fn ($l) => explode(' bags contain ', $l, 2))
            ->filter(fn ($a) => str_contains($a[1], $description))
            ->map(fn ($a) => $a[0])
            ->toArray();
    }
}