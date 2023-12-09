<?php

namespace AOC2023\Day9;

function extrapolate($array): int
{
    $allZero = static function(array $array, int $value): bool {
        foreach ($array as $item) {
            if ($item !== $value) {
                return false;
            }
        }

        return true;
    };

    if ($allZero($array, 0)) {
        return 0;
    }

    $deltas = [];

    for ($i = 0; $i < count($array) - 1; $i++) {
        $deltas[] = $array[$i + 1] - $array[$i];
    }

    $diff = extrapolate($deltas);

    return end($array) + $diff;
}

function part1(string $input): int
{
    $lines = explode(PHP_EOL, trim($input, PHP_EOL));

    $sum = 0;

    foreach ($lines as $line) {
        if ('' === $line) {
            continue;
        }

        $nums = array_map(static fn ($value) => (int) $value, explode(' ', $line));
        $sum += extrapolate($nums);
    }

    return $sum;
}

check('2023 Day 9 Part 1 Example', '2023/inputs/day-9/part-1-example.txt', part1(...), 114);
produce('2023 Day 9 Part 1', '2023/inputs/day-9/input.txt', part1(...));

function part2(string $input): int
{
    $lines = explode(PHP_EOL, trim($input, PHP_EOL));
    $sum = 0;

    foreach ($lines as $line) {
        if ('' === $line) {
            continue;
        }

        $nums = array_map(static fn ($value) => (int) $value, explode(' ', $line));
        $sum += extrapolate(array_reverse($nums));
    }

    return $sum;
}

check('2023 Day 9 Part 2 Example', '2023/inputs/day-9/part-2-example.txt', part2(...), 2);
produce('2023 Day 9 Part 2', '2023/inputs/day-9/input.txt', part2(...));
