<?php

namespace GerritDrost\AoC2020\Day8;

use Exception;
use Throwable;

class InfLoopException extends Exception
{
    public function __construct(public int $accumulator)
    {
        parent::__construct("Processor got stuck in an infinite loop");
    }
}