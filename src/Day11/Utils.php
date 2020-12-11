<?php

namespace GerritDrost\AoC2020\Day11;

use DusanKasan\Knapsack\Collection;
use GerritDrost\AoC2020\Utils\Arrays;

class Utils
{
    public static function read($inputHandle): array {
        $lines = Arrays::linesFromHandle($inputHandle);

        $w = strlen($lines[0]);
        $h = count($lines);

        // Read the initial layout
        $layout = str_split(implode('', $lines));

        return [$layout, $w, $h];
    }

    public static function filterSeatIndices(array $layout): array {
        return Collection::from($layout)
            ->filter(fn ($char) => $char !== '.')
            ->map(fn ($char, $i) => $i)
            ->toArray();
    }

    public static function computePaths(int $w, int $h): array {
        $horizontalPaths = Collection::range(0, $h - 1)
            ->map(
                fn ($y) => Collection
                    ::range(0, $w - 1)
                    ->map(fn ($x) => [$x, $y])
                    ->toArray()
            )
            ->filter(fn ($path) => count($path) > 1)
            ->realize();

        $verticalPaths = Collection::range(0, $w - 1)
            ->map(
                fn ($x) => Collection
                    ::range(0, $h - 1)
                    ->map(fn ($y) => [$x, $y])
                    ->toArray()
            )
            ->filter(fn ($path) => count($path) > 1)
            ->realize();

        $diagonalRanges = [
            [[-1, 1], 0, ($w + $h) - 2],
            [[1, 1], -($h - 1), $w - 1],
        ];

        $diagonalPaths = Collection
            ::from($diagonalRanges)
            ->mapcat(
                function (array $params) use ($w, $h) {
                    [[$dX, $dY], $xStart, $xEnd] = $params;

                    return Collection
                        ::range($xStart, $xEnd)
                        ->map(
                            fn ($x0) => Collection
                                ::iterate([$x0, 0], fn ($c) => [$c[0] + $dX, $c[1] + $dY])
                                ->take($h)
                                ->filter(fn ($c) => $c[0] >= 0 && $c[0] < $w && $c[1] >= 0 && $c[1] < $h)
                                ->toArray()
                        );
                }
            )
            ->filter(fn ($path) => count($path) > 1)
            ->values()
            ->realize();

        $pathReverser = fn ($path, $_) => array_reverse($path);
        $pathIndexer  = fn ($path, $_) => array_map(fn($c) => $c[1] * $w + $c[0], $path);

        return $horizontalPaths
            ->concat($verticalPaths)
            ->concat($diagonalPaths)
            ->concat($horizontalPaths->map($pathReverser))
            ->concat($verticalPaths->map($pathReverser))
            ->concat($diagonalPaths->map($pathReverser))
            ->values()
            ->map($pathIndexer)
            ->toArray();
    }
}