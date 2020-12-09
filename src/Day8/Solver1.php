<?php

namespace GerritDrost\AoC2020\Day8;

use GerritDrost\AoC2020\Solver;

class Solver1 implements Solver
{
    public function solve($inputHandle): int
    {
        $instructions = Reader::readInstructionsFromHandle($inputHandle);

        try {
            $accumulator = Processor::run($instructions);
        } catch (InfLoopException $e) {
            $accumulator = $e->accumulator;
        }

        return $accumulator;
    }
}