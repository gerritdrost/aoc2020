<?php

namespace GerritDrost\AoC2020\Utils;

use Closure;

class Predicates
{
    public static function mapped(callable $mapper, callable $predicate): Closure
    {
        return fn ($value) => $predicate($mapper($value));
    }

    public static function chain(callable ...$predicates): Closure
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

    public static function arrayHasKeys(array $keys): Closure
    {
        return function (array $value) use ($keys): bool {
            return empty(array_diff($keys, array_keys($value)));
        };
    }

    public static function intBetween(int $min, int $max): Closure
    {
        return fn ($value) => $value >= $min && $value <= $max;
    }

    public static function regex(string $pattern): Closure
    {
        return fn ($value) => preg_match($pattern, $value) === 1;
    }
}