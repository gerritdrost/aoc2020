<?php

namespace GerritDrost\AoC2020\Day11;

use GerritDrost\AoC2020\Solver;

class Solver2 implements Solver
{
    public function solve($inputHandle): int
    {
        // Read layout
        [$layout, $w, $h] = Utils::read($inputHandle);

        // Array containing indices of seats (no need to evaluate the floor)
        $seatIndices = Utils::filterSeatIndices($layout);

        // Array of all orthogonal and diagonal paths present in the grid. Paths are directional (every row has 2 paths, one left, one right).
        $paths = Utils::computePaths($w, $h);

        // Keep computing until nothing changes
        do {
            $layout = $this->computeNewLayout($layout, $w, $h, $paths, $seatIndices, $changed);
        } while ($changed > 0);

        return count(array_filter($layout, fn ($v) => $v === '#'));
    }

    private function computeNewLayout(array $layout, int $w, int $h, array $paths, array $seatIndices, ?int &$changed): array {
        $counts = $this->countOccupiedAdjacentSeats($layout, $paths, $w, $h);

        $newLayout = $layout;
        $changed   = 0;
        foreach ($seatIndices as $i) {
            $occupiedAdjacentCount = $counts[$i];

            $value = $layout[$i];
            if ($value === 'L' && $occupiedAdjacentCount === 0) {
                $newLayout[$i] = '#';
                $changed++;
            } elseif ($value === '#' && $occupiedAdjacentCount >= 5) {
                $newLayout[$i] = 'L';
                $changed++;
            }
        }

        return $newLayout;
    }

    private function countOccupiedAdjacentSeats(array $layout, array $paths, int $w, int $h) {
        $counts = array_fill(0, $w * $h, 0);

        foreach ($paths as $path) {
            $prev = false;
            foreach ($path as $i) {
                $value = $layout[$i];

                if ($value === '.') {
                    continue;
                }

                if ($prev) {
                    $counts[$i]++;
                }

                $prev = ($value === '#');
            }
        }

        return $counts;
    }
}