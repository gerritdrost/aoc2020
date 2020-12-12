<?php

function using(...$args)
{
    return fn (callable $callable) => $callable(...$args);
}

function open_file(string $path)
{
    if (!is_readable($path)) {
        throw new InvalidArgumentException("File {$path} does not exist or cannot be read");
    }

    $inputFile   = $path;
    $inputHandle = fopen($inputFile, 'r');
    register_shutdown_function(fn () => @fclose($inputHandle));

    return $inputHandle;
}

function bytes_from_string(string $v): Generator
{
    $generator = function () use ($v) {
        $len = strlen($v);
        for ($i = 0; $i < $len; $i++) {
            yield $v[$i];
        }
    };

    return $generator();
}

function lines_from_handle($handle, bool $skipEmptyLines = true): Generator
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

function linegroups_from_handle($handle): Generator
{
    $generator = function () use ($handle) {
        $buffer = [];

        foreach (lines_from_handle($handle, false) as $line) {
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

function int_lines_from_handle($handle): Generator
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

function fn_int_between(int $min, int $max): Closure
{
    return fn ($value) => $value >= $min && $value <= $max;
}

function fn_matches_regex(string $pattern): Closure
{
    return fn ($value) => preg_match($pattern, $value) === 1;
}

function fn_array_has_keys(array $keys): Closure
{
    return fn (array $value) => empty(array_diff($keys, array_keys($value)));
}

function fn_mapped(callable $mapper, callable $callable): Closure
{
    return fn ($value) => $callable($mapper($value));
}

function fn_every(callable ...$predicates): Closure
{
    return function ($value) use ($predicates): bool {
        foreach ($predicates as $predicate) {
            if ($predicate($value) == false) {
                return false;
            }
        }

        return true;
    };
}