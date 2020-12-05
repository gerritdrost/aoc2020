<?php

namespace GerritDrost\AoC2020\Day2;

use InvalidArgumentException;

class InputEntry
{
    public function __construct(
        public int $firstNumber,
        public int $secondNumber,
        public string $requiredChar,
        public string $password
    ) { }

    public static function fromInputLine(string $line): InputEntry {
        if (preg_match(
            '/^(?<mustContainIndex>\d+)-(?<mustNotContainIndex>\d+) (?<requiredChar>\w): (?<password>\w+)$/',
            $line,
            $matches
        )) {
            return new InputEntry(
                intval($matches['mustContainIndex']),
                intval($matches['mustNotContainIndex']),
                $matches['requiredChar'],
                $matches['password']
            );
        }

        throw new InvalidArgumentException("Could not match line {$line}. Invalid input or programming error.");
    }
}