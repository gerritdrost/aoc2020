<?php

use GerritDrost\AoC2020\Files;

require __DIR__ . '/../bootstrap.php';

$solver = new GerritDrost\AoC2020\Day1\Solver2();

$inputHandle = Files::openForReading(PROJECT_ROOT_DIR . '/res/day/1/input');
echo $solver->solve($inputHandle) . PHP_EOL;