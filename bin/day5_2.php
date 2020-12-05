<?php

use GerritDrost\AoC2020\Utils\Files;

require __DIR__ . '/../bootstrap.php';

$solver = new GerritDrost\AoC2020\Day5\Solver2();

$inputHandle = Files::openForReading(PROJECT_ROOT_DIR . '/res/day/5/input');
echo $solver->solve($inputHandle) . PHP_EOL;