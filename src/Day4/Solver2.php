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

        $validateDoc = fn_every(
            fn_array_has_keys($requiredFields),
            fn_mapped(fn ($doc) => $doc['byr'], fn_int_between(1920, 2002)),
            fn_mapped(fn ($doc) => $doc['iyr'], fn_int_between(2010, 2020)),
            fn_mapped(fn ($doc) => $doc['eyr'], fn_int_between(2020, 2030)),
            fn_mapped(fn ($doc) => $doc['hgt'], fn($hgt) => self::validateHgt($hgt)),
            fn_mapped(fn ($doc) => $doc['hcl'], fn_matches_regex('/^#[0-9a-f]{6}$/')),
            fn_mapped(fn ($doc) => $doc['ecl'], fn ($ecl) => in_array($ecl, $validEyeColors)),
            fn_mapped(fn ($doc) => $doc['pid'], fn ($pid) => ctype_digit($pid) && strlen($pid) === 9)
        );

        return Utils::readDocs($inputHandle)
            ->filter($validateDoc)
            ->size();
    }

    public static function validateHgt(string $hgt): bool {
        $unit  = substr($hgt, -2);
        $value = intval(substr($hgt, 0, -2));

        $predicate = match ($unit) {
            'cm' => fn_int_between(150, 193),
            'in' => fn_int_between(59, 76),
            default => fn($_) => false
        };

        return $predicate($value);
    }
}