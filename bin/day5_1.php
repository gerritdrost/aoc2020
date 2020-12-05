<?php

use DusanKasan\Knapsack\Collection;
use GerritDrost\AoC2020\Arrays;
use GerritDrost\AoC2020\Files;
use GerritDrost\AoC2020\Generators;

require __DIR__ . '/../bootstrap.php';

$solver = function (): int {
    $inputHandle = Files::openForReading(PROJECT_ROOT_DIR . '/res/day/4/input');
    $lines       = Generators::linesFromHandle($inputHandle, false);


    $validDocs = Collection
        ::from($lines)
        ->size();

    echo "Valid documents: {$validDocs}\n";

    return 0;
};

exit($solver());