<?php

use GerritDrost\AoC2020\Utils\Files;

require __DIR__ . '/../bootstrap.php';

$solver = new GerritDrost\AoC2020\Day1\Solver1();

$inputHandle = Files::openForReading(PROJECT_ROOT_DIR . '/res/day/1/input');
echo $solver->solve($inputHandle) . PHP_EOL;