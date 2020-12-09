<?php

namespace GerritDrost\AoC2020\Day9;

class Utils
{
    public static function computeSums(array $numbers)
    {
        $size     = count($numbers);
        $products = [];

        for ($i = 0; $i < ($size - 1); $i++) {
            for ($j = $i + 1; $j < $size; $j++) {
                $products[] = $numbers[$i] + $numbers[$j];
            }
        }

        return array_unique($products);
    }
}