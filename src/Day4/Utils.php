<?php

namespace GerritDrost\AoC2020\Day4;

use DusanKasan\Knapsack\Collection;
use GerritDrost\AoC2020\Generators;

class Utils
{
    public static function readDocs($inputHandle): Collection
    {
        $lines = Generators::linesFromHandle($inputHandle, false);

        $docLinesToDocString = function (Collection $docLines) {
            return $docLines->reduce(fn ($tmp, $line) => trim("{$tmp} {$line}"), '');
        };

        $docStringToMap = fn (string $docString) => Collection
            ::from(explode(' ', $docString))
            ->map(fn ($kvs) => explode(':', $kvs, 2))
            ->indexBy(fn ($kvp) => $kvp[0])
            ->map(fn ($kvp) => $kvp[1])
            ->toArray();

        return Collection
            ::from($lines)
            ->partitionBy(fn ($line) => empty($line))
            ->map($docLinesToDocString)
            ->filter()
            ->map($docStringToMap);
    }
}