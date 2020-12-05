<?php

namespace GerritDrost\AoC2020\Day5;

class Seat
{
    public int $id;

    public function __construct(public int $row, public int $column)
    {
        $this->id = ($row * 8) + $column;
    }
}