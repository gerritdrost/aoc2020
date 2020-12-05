<?php

namespace GerritDrost\AoC2020;

interface Solver
{
    /**
     * @param resource $inputHandle
     */
    public function solve($inputHandle): int;
}