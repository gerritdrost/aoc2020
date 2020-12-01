<?php

use GerritDrost\AoC2020\Generators;

require __DIR__ . '/../bootstrap.php';

$solver = function (): int {
    $inputFile   = PROJECT_ROOT_DIR . '/res/day/1/input';
    $inputHandle = fopen($inputFile, 'r');
    register_shutdown_function(fn () => @fclose($inputHandle));

    $numbers = iterator_to_array(Generators::intLinesFromHandle($inputHandle));
    sort($numbers);

    $size = count($numbers);

    for ($i = 0; $i < $size; $i++) {
        $ni = $numbers[$i];

        for ($j = $size - 1; $j > $i; $j--) {
            $nj = $numbers[$j];

            $sum = $ni + $nj;
            if ($sum === 2020) {
                $solution = $ni * $nj;
                echo "{$ni} + {$nj} == 2020\n  -> {$ni} * {$nj} = {$solution}";

                return 0;
            } elseif ($sum < 2020) {
                break;
            }
        }
    }

    return 1;
};

exit($solver());