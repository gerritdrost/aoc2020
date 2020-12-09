<?php

namespace GerritDrost\AoC2020\Day8;

use DusanKasan\Knapsack\Collection;
use GerritDrost\AoC2020\Utils\Generators;

class Reader
{
    public static function readInstructionsFromHandle($inputHandle): array {
        $lines = Generators::linesFromHandle($inputHandle);

        $mapper = function (string $line): array {
            [$instruction, $argument] = explode(' ', $line);

            return [$instruction, intval($argument)];
        };

        return Collection::from($lines)
            ->map($mapper)
            ->toArray();
    }
}