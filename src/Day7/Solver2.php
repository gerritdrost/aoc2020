<?php

namespace GerritDrost\AoC2020\Day7;

use DusanKasan\Knapsack\Collection;
use GerritDrost\AoC2020\Solver;

class Solver2 implements Solver
{
    public function solve($inputHandle): int
    {
        $lines = lines_from_handle($inputHandle);

        $parsed = Collection::from($lines)
            ->map(fn ($l) => explode(' bags contain ', $l, 2))
            ->indexBy(fn ($a) => $a[0])
            ->map(fn ($a) => $this->parseContentBags($a[1]))
            ->toArray();

        $stack = [[1, $parsed['shiny gold']]];
        $count = 0;
        while (!empty($stack)) {
            $item = array_pop($stack);

            [$bagQty, $bagContents] = $item;

            foreach ($bagContents as $innerBag => $innerQty) {
                $qty = $bagQty * $innerQty;

                // Increment bag counter
                $count += $qty;

                // Add bag to stack
                array_push($stack, [$qty, $parsed[$innerBag]]);
            }
        }

        return $count;
    }

    private function parseContentBags(string $descriptions): array
    {
        if ($descriptions === 'no other bags.') {
            return [];
        }

        return Collection
            ::from(explode(', ', $descriptions))
            ->map(fn (string $description) => explode(' ', $description, 4))
            ->map(fn (array $parts) => [$parts[0], "{$parts[1]} {$parts[2]}"])
            ->indexBy(fn (array $pair) => $pair[1])
            ->map(fn (array $pair) => intval($pair[0]))
            ->toArray();
    }
}