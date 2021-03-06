<?php

namespace GerritDrost\AoC2020\Day12;

use DusanKasan\Knapsack\Collection;
use GerritDrost\AoC2020\Solver;

class Solver1 implements Solver
{
    public function solve($inputHandle): int
    {
        $lines = lines_from_handle($inputHandle);

        $coord = Collection
            ::from($lines)
            //
            // map to [action, value, delta direction]
            ->map(fn ($l) => [$l[0], intval(substr($l, 1)), 0])
            //
            // For all R/L-actions, replace them with action F0 and set delta direction. Leave rest untouched.
            // We now only have actions 'F', 'N', 'E', 'S', 'W'
            ->map(
                fn ($a) => match ($a[0]) {
                    'R' => ['F', 0, $a[1] / 90],
                    'L' => ['F', 0, 4 - ($a[1] / 90)],
                    default => $a
                }
            )
            //
            // Turn [action, value, delta direction] into [action, value, direction]. Initial direction is E (1).
            ->reductions(
                fn ($tmp, $a) => [$a[0], $a[1], ($tmp[2] + $a[2]) % 4],
                ['F', 0, 1]
            )
            //
            // Map [action, value, direction] into [action, value], replacing all F's with their actual direction.
            // We now only have action 'N', 'E', 'S', 'W'
            ->map(
                fn ($a) => using(...$a)(
                    fn ($action, $value, $direction) => match ($action) {
                        'F' => [C::DIRECTIONS[$direction], $value],
                        default => [$action, $value]
                    }
                )
            )
            //
            // Filter out all F0's
            ->filter(fn ($a) => $a[1] > 0)
            //
            // Translate all instructions into coordinate deltas
            ->map(
                fn ($a) => using(C::DELTAS[$a[0]], $a[1])(
                    fn ($delta, $v) => [$delta[0] * $v, $delta[1] * $v]
                )
            )
            //
            // Reduce coordinate deltas into final coordinate. Initial coordinate is [0, 0]
            ->reduce(fn ($pos, $delta) => [$pos[0] + $delta[0], $pos[1] + $delta[1]], [0, 0]);

        return array_sum(array_map('abs', $coord));
    }
}