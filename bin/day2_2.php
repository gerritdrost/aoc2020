<?php

use GerritDrost\AoC2020\Files;

require __DIR__ . '/../bootstrap.php';

$solver = new GerritDrost\AoC2020\Day2\Solver2();

$inputHandle = Files::openForReading(PROJECT_ROOT_DIR . '/res/day/2/input');
echo $solver->solve($inputHandle) . PHP_EOL;