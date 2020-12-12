<?php

namespace GerritDrost\AoC2020\Day4;

use GerritDrost\AoC2020\Solver;
use GerritDrost\AoC2020\Utils\Predicates;

class Solver1 implements Solver
{
    public function solve($inputHandle): int
    {
        $requiredFields = ['byr', 'iyr', 'eyr', 'hgt', 'hcl', 'ecl', 'pid'];

        return Utils::readDocs($inputHandle)
            ->filter(fn_array_has_keys($requiredFields))
            ->size();
    }
}