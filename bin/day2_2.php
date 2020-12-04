<?php

use DusanKasan\Knapsack\Collection;
use GerritDrost\AoC2020\Files;
use GerritDrost\AoC2020\Generators;

require __DIR__ . '/../bootstrap.php';

class InputEntry
{
    public function __construct(
        public int $index1,
        public int $index2,
        public string $requiredChar,
        public string $password
    ) { }

    public function __toString(): string
    {
        return sprintf(
            '%d-%d %s: %s',
            $this->index1,
            $this->index2,
            $this->requiredChar,
            $this->password
        );
    }
}

$solver = function (): int {
    $inputHandle = Files::openForReading(PROJECT_ROOT_DIR . '/res/day/2/input');

    $lineGenerator = Generators::linesFromHandle($inputHandle);

    $mapLine = function (string $line): InputEntry {
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
    };

    $checkPassword = function (InputEntry $inputEntry) {
        $password = $inputEntry->password;

        // Input is 1-based, mb_substr is 0-based
        $indices = [$inputEntry->index1 - 1, $inputEntry->index2 - 1];

        $requiredChar = $inputEntry->requiredChar;

        $numberOfOccurences = Collection
            ::from($indices)
            ->filter(fn($index) => mb_substr($password, $index, 1) === $requiredChar)
            ->size();


        return $numberOfOccurences === 1;
    };

    $count = Collection
        ::from($lineGenerator)
        ->map($mapLine)
        ->filter($checkPassword)
        ->each(fn ($item) => printf("%s\n", $item))
        ->size();

    echo "\nValid password count: $count\n";

    return 0;
};

exit($solver());