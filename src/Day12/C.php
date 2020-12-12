<?php

namespace GerritDrost\AoC2020\Day12;

class C
{
    /**
     *                 N
     *                 2
     *                 1
     * W ..., -2, -1,  0,  1,  2, ... E
     *                -1
     *                -2
     *                 S
     */
    public const DELTAS = [
        'N' => [0, 1],  // N
        'E' => [1, 0],  // E
        'S' => [0, -1], // S
        'W' => [-1, 0], // W
    ];

    public const DIRECTIONS = ['N', 'E', 'S', 'W'];
}