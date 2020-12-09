<?php

namespace GerritDrost\AoC2020\Day9;

use DusanKasan\Knapsack\Collection;
use GerritDrost\AoC2020\Solver;
use GerritDrost\AoC2020\Utils\Arrays;

class Solver2 implements Solver
{
    private Solver1 $solver1;

    public function __construct(private int $preambleSize = 25)
    {
        $this->solver1 = new Solver1($this->preambleSize);
    }

    public function solve($inputHandle): int
    {
        $ints = Arrays::intLinesFromHandle($inputHandle);

        $requiredSum = $this->solver1->solve($ints);

        $window = new Window($ints);

        while ($window->start < count($ints)) {
            $diff = $requiredSum - $window->sum;

            if ($diff === 0) {
                $slice = Collection
                    ::from($window->slice())
                    ->realize();

                return $slice->min() + $slice->max();
            } elseif ($diff > 0) {
                $window->growRear();
            } elseif ($diff < 0) {
                $window->shrinkFront();
            }
        }

        return $requiredSum;
    }
}