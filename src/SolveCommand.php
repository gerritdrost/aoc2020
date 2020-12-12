<?php

namespace GerritDrost\AoC2020;

use GerritDrost\AoC2020\Utils\Files;
use InvalidArgumentException;
use RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class SolveCommand extends Command
{
    protected static $defaultName = 'solve';

    protected function configure()
    {
        $this
            ->addArgument(
                'day',
                InputArgument::REQUIRED,
                'Puzzle day'
            )
            ->addArgument(
                'part',
                InputArgument::OPTIONAL,
                'Part 1 or 2 of the specified day',
                '2'
            )
            ->addOption(
                'input',
                'i',
                InputOption::VALUE_REQUIRED,
                'Custom input file path'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $day       = self::sanitizeDay($input->getArgument('day'));
        $part      = self::sanitizePart($input->getArgument('part'));
        $inputFile = $input->getOption('input');

        $solution = SolveService::solve($day, $part, $inputFile);
        $output->writeln($solution);

        return 0;
    }

    private static function sanitizeDay(string $day): int
    {
        if (!ctype_digit($day)) {
            throw new InvalidArgumentException("Day must be a positive integer, got {$day}");
        }

        $day = intval($day);
        if ($day < 1 || $day > 25) {
            throw new InvalidArgumentException("Day does not satisfy 1 <= day <= 25");
        }

        return $day;
    }

    private static function sanitizePart(string $part): int
    {
        if (!in_array($part, ['1', '2'], true)) {
            throw new InvalidArgumentException("Part can either be '1' or '2', got {$part}");
        }

        return intval($part);
    }
}