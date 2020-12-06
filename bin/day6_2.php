<?php

use GerritDrost\AoC2020\Utils\Files;

require __DIR__ . '/../bootstrap.php';

$solver = new GerritDrost\AoC2020\Day6\Solver2();

$inputHandle = Files::openForReading(PROJECT_ROOT_DIR . '/res/day/6/input');
echo $solver->solve($inputHandle) . PHP_EOL;