<?php

namespace GerritDrost\AoC2020\Day8;

class State
{
    public function __construct(public array $instructions, public int $instructionIndex) {}
}