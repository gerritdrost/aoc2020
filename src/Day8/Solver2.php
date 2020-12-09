<?php

namespace GerritDrost\AoC2020\Day8;

use DusanKasan\Knapsack\Collection;
use GerritDrost\AoC2020\Solver;

class Solver2 implements Solver
{
    public function solve($inputHandle): int
    {
        $instructions = Reader::readInstructionsFromHandle($inputHandle);

        /*
         * Provided a jmp/nop instruction and its index, creates a copy of the original list of instructions, switches
         * nop <=> jmp-switch at that index and executes the code. Returns the accumulator-value at termination, or
         * null if an infinite loop is detected.
         */
        $testMapper = function (array $p, int $i) use ($instructions): ?int {
            [$instruction, $argument] = $p;

            $testInstructions = $instructions;

            $testInstructions[$i] = [
                $instruction === 'jmp' ? 'nop' : 'jmp',
                $argument,
            ];

            try {
                return Processor::run($testInstructions);
            } catch (InfLoopException $e) {
                return null;
            }
        };

        return Collection::from($instructions)
            ->filter(fn (array $p) => in_array($p[0], ['jmp', 'nop'], true))
            ->map($testMapper)
            ->dropWhile(fn ($acc) => $acc === null)
            ->first();
    }
}