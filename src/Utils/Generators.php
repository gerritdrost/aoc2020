<?php

namespace GerritDrost\AoC2020\Utils;

use Generator;

class Generators
{
    /**
     * @param resource $handle         the handle to read from
     * @param bool     $skipEmptyLines when set to true, only non-empty files are yielded
     *
     * @return Generator
     */
    public static function linesFromHandle($handle, bool $skipEmptyLines = true): Generator
    {
        $generator = function () use ($handle, $skipEmptyLines) {
            while (($line = fgets($handle)) !== false) {
                $line = trim($line);

                if ($skipEmptyLines && empty($line)) {
                    continue;
                }

                yield $line;
            }
        };

        return $generator();
    }

    /**
     * Reads line from the handle, and yields them as arrays of non-empty lines separated by empty lines. E.g.:
     *
     * ---
     * a
     * b
     *
     * foo
     * bar
     *
     * foobarbaz
     * ---
     *
     * would result in these three arrays being yielded by the generator: ['a', 'b'], ['foo', 'bar'], ['foobarbaz']
     *
     * @param resource $handle the handle to read from
     */
    public static function lineGroupsFromHandle($handle)
    {
        $generator = function () use ($handle) {
            $buffer = [];

            foreach (self::linesFromHandle($handle, false) as $line) {
                if (!empty($line)) {
                    $buffer[] = $line;
                } elseif (!empty($buffer)) {
                    yield $buffer;
                    $buffer = [];
                }
            }

            if (!empty($buffer)) {
                yield $buffer;
            }
        };

        return $generator();
    }

    /**
     * Reads lines from file, casts them to int, and then yields them.
     *
     * @param resource $handle the handle to read from
     */
    public static function intLinesFromHandle($handle): Generator
    {
        $generator = function () use ($handle) {
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