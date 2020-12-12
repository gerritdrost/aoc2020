<?php

namespace GerritDrost\AoC2020\Day1;

use GerritDrost\AoC2020\Utils\Generators;
use GerritDrost\AoC2020\Solver;
use RuntimeException;

class Solver2 implements Solver
{
    public function solve($inputHandle): int
    {
        $numbers = iterator_to_array(int_lines_from_handle($inputHandle));
        sort($numbers);

        $size = count($numbers);

        for ($i = 0; $i < $size; $i++) {
            $ni = $numbers[$i];

            for ($j = $size - 1; $j > $i; $j--) {
                $nj = $numbers[$j];

                for ($k = $i + 1; $k < $j; $k++) {
                    $nk = $numbers[$k];

                    $sum = $ni + $nj + $nk;
                    if ($sum === 2020) {
                        return $ni * $nj * $nk;
                    } elseif ($sum < 2020) {
                        break;
                    }
                }
            }
        }

        throw new RuntimeException("No solution found");
    }
}