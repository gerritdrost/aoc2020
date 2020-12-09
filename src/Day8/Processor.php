<?php

namespace GerritDrost\AoC2020\Day8;

use InvalidArgumentException;
use function DusanKasan\Knapsack\repeat;

class Processor
{
    public static function run(array $instructions): int
    {
        $invocations      = repeat(0, count($instructions))->toArray();
        $accumulator      = 0;
        $i                = 0;
        $instructionCount = count($instructions);

        while (true) {
            // The program terminates if $i moves to an instruction after the last instruction
            if ($i >= $instructionCount) {
                break;
            }

            // The program loops if the instruction at index $i is reached more than once
            if ($invocations[$i] > 0) {
                throw new InfLoopException($accumulator);
            }

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