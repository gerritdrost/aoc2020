<?php

namespace GerritDrost\AoC2020\Day9;

use DusanKasan\Knapsack\Collection;
use GerritDrost\AoC2020\Solver;
use GerritDrost\AoC2020\Utils\Arrays;
use RuntimeException;

class Solver2 implements Solver
{
    private Solver1 $solver1;

    public function __construct(private int $preambleSize = 25)
    {
        $this->solver1 = new Solver1($this->preambleSize);
    }

    public function solve($inputHandle): int
    {
        $ints = iterator_to_array(int_lines_from_handle($inputHandle));

        // Use the solver of part 1 to get the required sum
        $requiredSum = $this->solver1->solve($ints);

        // Find slice
        $slice = $this->findContiguousSliceWithSum($ints, $requiredSum);

        // Result is sum of least and greatest number in slice
        return $slice->min() + $slice->max();
    }

    private function findContiguousSliceWithSum(array $ints, int $requiredSum): Collection
    {
        $window = new Window($ints);

        while ($window->start < count($ints)) {
            $diff = $requiredSum - $window->sum;

            if ($diff === 0) {
                return Collection::from($window->slice());
            } elseif ($diff > 0) {
                $window->growRear();
            } elseif ($diff < 0) {
                $window->shrinkFront();
            }
        }

        throw new RuntimeException("Contiguous slice with sum {$requiredSum} does not exist in provided array");
    }
}