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
        $day = self::sanitizeDay($input->getArgument('day'));
        $part = self::sanitizePart($input->getArgument('part'));

        // Do some nasty stuff to dynamically load the right solver.
        $solverClass = __NAMESPACE__ . "\Day{$day}\Solver{$part}";

        if (!class_exists($solverClass, true)) {
            throw new RuntimeException("Solution to day ${day} puzzle {$part} not implemented yet");
        }

        $solver = new $solverClass();

        // Open file, solve, print
        $inputPath = $overridePath ?? (PROJECT_ROOT_DIR . "/res/day/{$day}/input");
        $inputHandle = self::openInputFile($inputPath);
        $solution = $solver->solve($inputHandle);
        $output->writeln($solution);

        return 0;
    }

    /**
     * @return resource
     */
    private static function openInputFile(string $path) {
        if (!is_readable($path)) {
            throw new InvalidArgumentException("File {$path} does not exist or cannot be read");
        }

        return Files::openForReading($path);
    }

    private static function sanitizeDay(string $day): int {
        if (!ctype_digit($day)) {
            throw new InvalidArgumentException("Day must be a positive integer, got {$day}");
        }

        $day = intval($day);
        if ($day < 1 || $day > 25) {
            throw new InvalidArgumentException("Day does not satisfy 1 <= day <= 25");
        }

        return $day;
    }

    private static function sanitizePart(string $puzzle): int {
        if (!in_array($puzzle, ['1', '2'], true)) {
            throw new InvalidArgumentException("Puzzle can either be '1' or '2', got {$puzzle}");
        }

        return intval($puzzle);
    }
}