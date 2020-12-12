<?php

namespace GerritDrost\AoC2020;

use InvalidArgumentException;
use RuntimeException;

class SolveService
{
    public static function solve(int $day, int $part, ?string $inputFile = null)
    {
        if ($day < 1 || $day > 25) {
            throw new InvalidArgumentException("Day does not satisfy 1 <= day <= 25");
        }

        if (!in_array($part, [1, 2], true)) {
            throw new InvalidArgumentException("Part can either be '1' or '2', got {$part}");
        }

        // Do some nasty stuff to dynamically load the right solver.
        $solverClass = __NAMESPACE__ . "\Day{$day}\Solver{$part}";

        if (!class_exists($solverClass, true)) {
            throw new RuntimeException("Solution to day ${day} part {$part} not implemented yet");
        }

        $solver = new $solverClass();

        // Open file, solve, print
        $inputPath   = $inputFile ?? (PROJECT_ROOT_DIR . "/res/day/{$day}/input");
        $inputHandle = open_file($inputPath);

        return $solver->solve($inputHandle);
    }
}