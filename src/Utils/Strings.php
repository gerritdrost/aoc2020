<?php

namespace GerritDrost\AoC2020\Utils;

use Generator;

class Strings
{
    public static function bytesFromString(string $v): Generator
    {
        $generator = function () use ($v) {
            $len = strlen($v);
            for ($i = 0; $i < $len; $i++) {
                yield $v[$i];
            }
        };

        return $generator();
    }
}