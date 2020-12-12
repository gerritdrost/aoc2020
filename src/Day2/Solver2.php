<?php

namespace GerritDrost\AoC2020\Day2;

use DusanKasan\Knapsack\Collection;
use GerritDrost\AoC2020\Solver;

class Solver2 implements Solver
{
    public function solve($inputHandle): int
    {
        $lineGenerator = lines_from_handle($inputHandle);

        $checkPassword = function (InputEntry $inputEntry) {
            $password = $inputEntry->password;

            // Input is 1-based, mb_substr is 0-based
            $indices = [$inputEntry->firstNumber - 1, $inputEntry->secondNumber - 1];

            $requiredChar = $inputEntry->requiredChar;

            $numberOfOccurences = Collection
                ::from($indices)
                ->filter(fn($index) => mb_substr($password, $index, 1) === $requiredChar)
                ->size();


            return $numberOfOccurences === 1;
        };

        return Collection
            ::from($lineGenerator)
            ->map([InputEntry::class, 'fromInputLine'])
            ->filter($checkPassword)
            ->size();
    }
}