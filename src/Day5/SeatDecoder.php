<?php

namespace GerritDrost\AoC2020\Day5;

use DusanKasan\Knapsack\Collection;
use GerritDrost\AoC2020\Utils\Strings;
use InvalidArgumentException;

class SeatDecoder
{
    public static function decode(string $code): Seat
    {
        $rowRange = [0, 128];
        $colRange = [0, 8];
        $binaryReducer = function(array $searchSpace, string $char) {
            [$r, $c] = $searchSpace;

            return match ($char) {
                'B' => [self::takeUpperHalf($r), $c],
                'F' => [self::takeLowerHalf($r), $c],
                'L' => [$r, self::takeLowerHalf($c)],
                'R' => [$r, self::takeUpperHalf($c)],
                default => throw new InvalidArgumentException("Invalid char {$char}")
            };
        };

        $chars = bytes_from_string($code);

        [$rowRange, $colRange] = Collection
            ::from($chars)
            ->reduce($binaryReducer, [$rowRange, $colRange]);

        if (
            ($rowRange[1] - $rowRange[0] !== 1)
            || ($colRange[1] - $colRange[0] !== 1)
        ) {
            throw new InvalidArgumentException("Code {$code} does not fully resolve to a seat");
        }

        return new Seat($rowRange[0], $colRange[0]);
    }

    public static function takeUpperHalf(array $r): array {
        return [$r[0] + (($r[1] - $r[0]) / 2), $r[1]];
    }

    public static function takeLowerHalf(array $r): array {
        return [$r[0], $r[1] - (($r[1] - $r[0]) / 2)];
    }
}