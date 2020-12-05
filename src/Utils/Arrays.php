<?php

namespace GerritDrost\AoC2020\Utils;

class Arrays
{
    /**
     * @param resource $handle
     *
     * @return string[]
     */
    public static function linesFromHandle($handle): array
    {
        return iterator_to_array(Generators::linesFromHandle($handle));
    }

    /**
     * @param resource $handle
     *
     * @return int[]
     */
    public static function intLinesFromHandle($handle): array
    {
        return iterator_to_array(Generators::intLinesFromHandle($handle));
    }
}