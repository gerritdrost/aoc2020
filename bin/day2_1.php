<?php

use DusanKasan\Knapsack\Collection;
use GerritDrost\AoC2020\Files;
use GerritDrost\AoC2020\Generators;

require __DIR__ . '/../bootstrap.php';

class InputEntry {
    public int $minOccurences;
    public int $maxOccurences;
    public string $requiredChar;
    public string $password;

    public function __construct(int $minOccurences, int $maxOccurences, string $requiredChar, string $password)
    {
        $this->minOccurences = $minOccurences;
        $this->maxOccurences = $maxOccurences;
        $this->requiredChar  = $requiredChar;
        $this->password      = $password;
    }

    public function __toString(): string
    {
        return sprintf('%d-%d %s: %s', $this->minOccurences, $this->maxOccurences, $this->requiredChar, $this->password);
    }
}

$solver = function (): int {
    $inputHandle = Files::openForReading(PROJECT_ROOT_DIR . '/res/day/2/input');

    $lineGenerator = Generators::linesFromHandle($inputHandle);

    $mapLine = function(string $line): InputEntry {
        if (preg_match('/^(?<minOcurrences>\d+)-(?<maxOcurrences>\d+) (?<requiredChar>\w): (?<password>\w+)$/', $line, $matches)) {
            return new InputEntry(
                intval($matches['minOcurrences']),
                intval($matches['maxOcurrences']),
                $matches['requiredChar'],
                $matches['password']
            );
        }

        throw new InvalidArgumentException("Could not match line {$line}. Invalid input or programming error.");
    };

    $checkPassword = function(InputEntry $inputEntry) {
        $count = mb_substr_count($inputEntry->password, $inputEntry->requiredChar);

        return
            $count >= $inputEntry->minOccurences
            && $count <= $inputEntry->maxOccurences;
    };

    $count = Collection
        ::from($lineGenerator)
        ->map($mapLine)
        ->filter($checkPassword)
        ->each(fn ($item) => printf("%s\n", $item))
        ->size();

    echo "Valid password count: $count\n";
    return 0;
};

exit($solver());