<?php

namespace GerritDrost\AoC2020\Day8;

use DusanKasan\Knapsack\Collection;
use GerritDrost\AoC2020\Utils\Arrays;
use GerritDrost\AoC2020\Solver;
use GerritDrost\AoC2020\Utils\Generators;
use InvalidArgumentException;
use function DusanKasan\Knapsack\repeat;

class Solver1 implements Solver
{
    public function solve($inputHandle): int
    {
        $lines = Generators::linesFromHandle($inputHandle);

        $mapper = function (string $line): array {
            [$instruction, $argument] = explode(' ', $line);

            return [$instruction, intval($argument)];
        };

        $instructions = Collection::from($lines)
            ->map($mapper)
            ->toArray();

        $invocations = repeat(0, count($instructions))->toArray();

        $accumulator = 0;
        $i           = 0;

        while ($invocations[$i] === 0) {
            $invocations[$i]++;

            [$instruction, $argument] = $instructions[$i];

            [$i, $accumulator] = match ($instruction) {
                'acc' => [$i + 1, $accumulator + $argument],
                'nop' => [$i + 1, $accumulator],
                'jmp' => [$i + $argument, $accumulator],
                default => throw new InvalidArgumentException("Encountered invalid instruction {$instruction}")
            };
        }

        return $accumulator;
    }
}