<?php

namespace GerritDrost\AoC2020\Day4;

use GerritDrost\AoC2020\Solver;
use GerritDrost\AoC2020\Utils\Predicates;

class Solver2 implements Solver
{
    public function solve($inputHandle): int
    {
        $requiredFields = ['byr', 'iyr', 'eyr', 'hgt', 'hcl', 'ecl', 'pid'];
        $validEyeColors = ['amb', 'blu', 'brn', 'gry', 'grn', 'hzl', 'oth'];

        $validateDoc = Predicates::chain(
            Predicates::arrayHasKeys($requiredFields),
            Predicates::mapped(fn ($doc) => $doc['byr'], Predicates::intBetween(1920, 2002)),
            Predicates::mapped(fn ($doc) => $doc['iyr'], Predicates::intBetween(2010, 2020)),
            Predicates::mapped(fn ($doc) => $doc['eyr'], Predicates::intBetween(2020, 2030)),
            Predicates::mapped(fn ($doc) => $doc['hgt'], fn($hgt) => self::validateHgt($hgt)),
            Predicates::mapped(fn ($doc) => $doc['hcl'], Predicates::regex('/^#[0-9a-f]{6}$/')),
            Predicates::mapped(fn ($doc) => $doc['ecl'], fn ($ecl) => in_array($ecl, $validEyeColors)),
            Predicates::mapped(fn ($doc) => $doc['pid'], fn ($pid) => ctype_digit($pid) && strlen($pid) === 9)
        );

        return Utils::readDocs($inputHandle)
            ->filter($validateDoc)
            ->size();
    }

    public static function validateHgt(string $hgt): bool {
        $unit  = substr($hgt, -2);
        $value = intval(substr($hgt, 0, -2));

        $predicate = match ($unit) {
            'cm' => Predicates::intBetween(150, 193),
            'in' => Predicates::intBetween(59, 76),
            default => fn($_) => false
        };

        return $predicate($value);
    }
}