<?php

use DusanKasan\Knapsack\Collection;
use GerritDrost\AoC2020\Arrays;
use GerritDrost\AoC2020\Files;

require __DIR__ . '/../bootstrap.php';

$solver = function (): int {$inputHandle = Files::openForReading(PROJECT_ROOT_DIR . '/res/day/3/input');
    $lines       = Arrays::linesFromHandle($inputHandle);
    $width       = strlen($lines[0]);

    $dx = 3;
    $treeCount = Collection
        ::from($lines)
        ->map(fn($line, $y) => substr($line, ($y * $dx) % $width, 1))
        ->filter(fn (string $char) => $char === '#')
        ->size();

    echo "Trees: $treeCount\n";

    return 0;
};

exit($solver());