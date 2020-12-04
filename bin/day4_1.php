<?php

use DusanKasan\Knapsack\Collection;
use GerritDrost\AoC2020\Arrays;
use GerritDrost\AoC2020\Files;
use GerritDrost\AoC2020\Generators;

require __DIR__ . '/../bootstrap.php';

$solver = function (): int {
    $inputHandle = Files::openForReading(PROJECT_ROOT_DIR . '/res/day/4/input');
    $lines       = Generators::linesFromHandle($inputHandle, false);

    $docLinesToDocString = function (Collection $docLines) {
        return $docLines->reduce(fn ($tmp, $line) => trim("{$tmp} {$line}"), '');
    };

    $docStringToMap = function (string $docString) {
        return Collection
            ::from(explode(' ', $docString))
            ->map(fn ($kvs) => explode(':', $kvs, 2))
            ->indexBy(fn ($kvp) => $kvp[0])
            ->map(fn ($kvp) => $kvp[1])
            ->toArray();
    };

    $requiredFields = ['byr', 'iyr', 'eyr', 'hgt', 'hcl', 'ecl', 'pid'];
    $validateDoc    = function (array $doc) use ($requiredFields) {
        $docFields = array_keys($doc);

        return empty(array_diff($requiredFields, $docFields));
    };

    $validDocs = Collection
        ::from($lines)
        ->partitionBy(fn ($line) => empty($line))
        ->map($docLinesToDocString)
        ->filter()
        ->map($docStringToMap)
        ->filter($validateDoc)
        ->size();

    echo "Valid documents: {$validDocs}\n";

    return 0;
};

exit($solver());