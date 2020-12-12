<?php

namespace GerritDrost\AoC2020\Day5;

use DusanKasan\Knapsack\Collection;
use GerritDrost\AoC2020\Solver;

class Solver1 implements Solver
{
    public function solve($inputHandle): int
    {
        $lines = lines_from_handle($inputHandle);

        return Collection::from($lines)
            ->map([SeatDecoder::class, 'decode'])
            ->map(fn(Seat $seat) => ($seat->row * 8) + $seat->column)
            ->max();
    }
}