<?php

namespace GerritDrost\AoC2020\Day1;

use GerritDrost\AoC2020\Utils\Generators;
use GerritDrost\AoC2020\Solver;
use RuntimeException;

class Solver1 implements Solver
{
    public function solve($inputHandle): int
    {
        $numbers = iterator_to_array(Generators::intLinesFromHandle($inputHandle));
        sort($numbers);

        $size = count($numbers);

        for ($i = 0; $i < $size; $i++) {
            $ni = $numbers[$i];

            for ($j = $size - 1; $j > $i; $j--) {
                $nj = $numbers[$j];

                $sum = $ni + $nj;
                if ($sum === 2020) {
                    return $ni * $nj;
                } elseif ($sum < 2020) {
                    break;
                }
            }
        }

        throw new RuntimeException("No solution found");
    }
}