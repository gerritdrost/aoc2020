<?php

namespace GerritDrost\AoC2020;

use Generator;

class Generators
{
    public static function intLinesFromHandle($handle): Generator
    {
        $generator = function() use ($handle) {
            while (($line = fgets($handle)) !== false) {
                $line = trim($line);

                if (empty($line)) {
                    continue;
                }

                yield intval($line);
            }
        };

        return $generator();
    }
}