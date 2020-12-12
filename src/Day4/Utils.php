<?php

namespace GerritDrost\AoC2020\Day4;

use DusanKasan\Knapsack\Collection;
use GerritDrost\AoC2020\Utils\Generators;

class Utils
{
    public static function readDocs($inputHandle): Collection
    {
        $lineGroups = linegroups_from_handle($inputHandle);

        $docStringToMap = fn (string $docString) => Collection
            ::from(explode(' ', $docString))
            ->map(fn ($kvs) => explode(':', $kvs, 2))
            ->indexBy(fn ($kvp) => $kvp[0])
            ->map(fn ($kvp) => $kvp[1])
            ->toArray();

        return Collection
            ::from($lineGroups)
            ->map(fn($docLines) => implode(' ', $docLines))
            ->filter()
            ->map($docStringToMap);
    }
}