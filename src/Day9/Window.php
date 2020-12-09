<?php

namespace GerritDrost\AoC2020\Day9;

class Window
{
    public int $start;
    public int $end;
    public int $sum;

    public function __construct(public array $ints)
    {
        $this->start = 0;
        $this->end   = 1;
        $this->sum   = $ints[0];
    }

    public function slice(): array {
        return array_slice(
            $this->ints,
            $this->start,
            $this->end - $this->start,
            false
        );
    }

    public function shrinkFront() {
        $newStart = min(count($this->ints), $this->start + 1);

        if ($newStart === $this->start) {
            return;
        }

        for ($i = $this->start; $i < $newStart; $i++) {
            $this->sum -= $this->ints[$i];
        }

        $this->start = $newStart;
    }

    public function growRear() {
        $newEnd = min(count($this->ints), $this->end + 1);

        if ($newEnd === $this->end) {
            return;
        }

        for ($i = $this->end; $i < $newEnd; $i++) {
            $this->sum += $this->ints[$i];
        }

        $this->end = $newEnd;
    }
}