<?php

namespace AOC2024\Day2;

function getReports(string $input): array
{
    return array_map(
        static function ($line) {
            $levels = explode(' ', $line);

            return array_map('intval', $levels);
        },
        explode(PHP_EOL, rtrim($input, PHP_EOL)),
    );
}

function safetyCheck(array $report): bool
{
    $safe = true;
    $increasing = false;
    $decreasing = false;

    for ($i = 0; $i < count($report) - 1; $i++) {
        $diff = $report[$i + 1] - $report[$i];

        $increasing = $increasing || $diff > 0;
        $decreasing = $decreasing || $diff < 0;

        $safe = ! ($diff > 3 || $diff === 0 || $diff < -3) && ! ($increasing && $decreasing);

        if (! $safe) {
            break;
        }
    }

    return $safe;
}

function part1(string $input): int
{
    $safeCount = 0;

    foreach (getReports($input) as $report) {
        if (safetyCheck($report)) {
            $safeCount++;
        }
    }

    return $safeCount;
}

check('2024 Day 2 Part 1 Example', '2024/inputs/day-2/part-1-example.txt', part1(...), 2);
produce('2024 Day 2 Part 1', '2024/inputs/day-2/input.txt', part1(...));

function isSafeWithDampener(array $report): bool
{
    if (safetyCheck($report)) {
        return true;
    }

    for ($i = 0, $iMax = count($report); $i < $iMax; $i++) {
        $modifiedReport = array_merge(
            array_slice($report, 0, $i),
            array_slice($report, $i + 1),
        );

        if (safetyCheck($modifiedReport)) {
            return true;
        }
    }

    return false;
}

function part2(string $input): int
{
    $safeCount = 0;

    foreach (getReports($input) as $report) {
        if (isSafeWithDampener($report)) {
            $safeCount++;
        }
    }

    return $safeCount;
}

check('2024 Day 2 Part 2 Example', '2024/inputs/day-2/part-2-example.txt', part2(...), 4);
produce('2024 Day 2 Part 2', '2024/inputs/day-2/input.txt', part2(...));
