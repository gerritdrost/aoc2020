<?php

use DusanKasan\Knapsack\Collection;
use GerritDrost\AoC2020\Files;
use GerritDrost\AoC2020\Generators;

require __DIR__ . '/../bootstrap.php';

$solver = function (): int {
    $inputHandle = Files::openForReading(PROJECT_ROOT_DIR . '/res/day/3/input');

    $lineGenerator = Generators::linesFromHandle($inputHandle);

    // Takes line as input, returns the character from this line on the toboggan path
    $mapToPathChar = function (string $line, int $y) {
        // no mb_ since ASCII
        $width = strlen($line);

        // Determine x-coordinate.
        $x = ($y * 3) % $width;

        return substr($line, $x, 1);
    };

    $treeCount = Collection
        ::from($lineGenerator)
        ->map($mapToPathChar)
        ->filter(fn (string $char) => $char === '#')
        ->size();

    echo "\nTrees: $treeCount\n";

    return 0;
};

exit($solver());