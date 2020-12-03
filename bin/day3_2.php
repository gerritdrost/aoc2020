<?php

use DusanKasan\Knapsack\Collection;
use GerritDrost\AoC2020\Arrays;
use GerritDrost\AoC2020\Files;

require __DIR__ . '/../bootstrap.php';

$solver = function (): int {
    $inputHandle = Files::openForReading(PROJECT_ROOT_DIR . '/res/day/3/input');
    $lines       = Arrays::linesFromHandle($inputHandle);
    $width       = strlen($lines[0]);

    $treeProduct = 1;
    $steps = [[1, 1], [3, 1], [5, 1], [7, 1], [1, 2]];
    foreach ($steps as $step) {
        [$dx, $dy] = $step;

        $treeCount = Collection
            ::from($lines)
            ->filter(fn ($_, $y) => $y % $dy === 0)
            ->indexBy(fn ($_, $y) => $y / $dy)
            ->map(fn($line, $y) => substr($line, ($y * $dx) % $width, 1))
            ->filter(fn (string $char) => $char === '#')
            ->size();

        echo "Step ($dx, $dy) => $treeCount trees\n";

        $treeProduct *= $treeCount;
    }

    echo "\nTree product: $treeProduct\n";

    return 0;
};

exit($solver());