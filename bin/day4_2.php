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

    $intBetween  = fn (int $i, int $min, int $max) => $i >= $min && $i <= $max;
    $validateByr = fn ($doc) => ctype_digit($doc['byr']) && $intBetween($doc['byr'], 1920, 2002);
    $validateIyr = fn ($doc) => ctype_digit($doc['iyr']) && $intBetween($doc['iyr'], 2010, 2020);
    $validateEyr = fn ($doc) => ctype_digit($doc['eyr']) && $intBetween($doc['eyr'], 2020, 2030);
    $validateHgt = function ($doc) use ($intBetween) {
        $hgt   = $doc['hgt'];
        $unit  = substr($hgt, -2);
        $value = intval(substr($hgt, 0, -2));

        switch ($unit) {
            case 'cm':
                return $intBetween($value, 150, 193);
            case 'in':
                return $intBetween($value, 59, 76);
            default:
                return false;
        }
    };
    $validateHcl = fn ($doc) => preg_match('/^#[0-9a-f]{6}$/', $doc['hcl']) === 1;
    $validateEcl = fn ($doc) => in_array($doc['ecl'], ['amb', 'blu', 'brn', 'gry', 'grn', 'hzl', 'oth']);
    $validatePid = fn ($doc) => ctype_digit($doc['pid']) && strlen($doc['pid']) === 9;

    $validDocs = Collection
        ::from($lines)
        ->partitionBy(fn ($line) => empty($line))
        ->map($docLinesToDocString)
        ->filter()
        ->map($docStringToMap)
        ->filter($validateDoc)
        ->filter($validateByr)
        ->filter($validateIyr)
        ->filter($validateEyr)
        ->filter($validateHgt)
        ->filter($validateHcl)
        ->filter($validateEcl)
        ->filter($validatePid)
        ->size();

    echo "Valid documents: {$validDocs}\n";

    return 0;
};

exit($solver());