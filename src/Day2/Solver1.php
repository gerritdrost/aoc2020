<?php

namespace GerritDrost\AoC2020\Day2;

use DusanKasan\Knapsack\Collection;
use GerritDrost\AoC2020\Solver;

class Solver1 implements Solver
{
    public function solve($inputHandle): int
    {$lineGenerator = lines_from_handle($inputHandle);

        $checkPassword = function (InputEntry $inputEntry) {
            $count = mb_substr_count($inputEntry->password, $inputEntry->requiredChar);

            return
                $count >= $inputEntry->firstNumber
                && $count <= $inputEntry->secondNumber;
        };

        return Collection
            ::from($lineGenerator)
            ->map([InputEntry::class, 'fromInputLine'])
            ->filter($checkPassword)
            ->size();
    }
}