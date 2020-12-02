<?php

namespace GerritDrost\AoC2020;

class Files
{
    public static function openForReading(string $path)
    {
        $inputFile   = $path;
        $inputHandle = fopen($inputFile, 'r');
        register_shutdown_function(fn () => @fclose($inputHandle));

        return $inputHandle;
    }
}