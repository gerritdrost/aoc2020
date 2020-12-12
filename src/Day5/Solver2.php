<?php

namespace GerritDrost\AoC2020\Day5;

use DusanKasan\Knapsack\Collection;
use GerritDrost\AoC2020\Solver;

class Solver2 implements Solver
{
    public function solve($inputHandle): int
    {
        $lines = lines_from_handle($inputHandle);

        $seatIds = Collection::from($lines)
            ->map([SeatDecoder::class, 'decode'])
            ->map(fn(Seat $seat) => $seat->id)
            ->sort(fn ($i1, $i2) => $i1 <=> $i2)
            ->values()
            ->toArray();

        [$minSeatId, $maxSeatId] = [$seatIds[0], $seatIds[count($seatIds) - 1]];

        return Collection
            ::range($minSeatId, $maxSeatId)
            ->diff($seatIds)
            ->first();
    }
}