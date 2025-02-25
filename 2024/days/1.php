<?php

namespace AOC2024\Day1;

function part1(string $input): int
{
    $leftList = [];
    $rightList = [];

    array_map(
        static function ($line) use (&$leftList, &$rightList) {
            $regex = '/\d+/ui';

            preg_match_all($regex, $line, $matches);

            $leftList[] = $matches[0][0];
            $rightList[] = $matches[0][1];
        },
        explode(PHP_EOL, rtrim($input, PHP_EOL)),
    );

    sort($leftList);
    sort($rightList);

    $totalDistance = 0;

    foreach ($leftList as $index => $leftValue) {
        $rightValue = $rightList[$index];
        $distance = abs($leftValue - $rightValue);
        $totalDistance += $distance;
    }

    return $totalDistance;
}

check('2024 Day 1 Part 1 Example', '2024/inputs/day-1/part-1-example.txt', part1(...), 11);
produce('2024 Day 1 Part 1', '2024/inputs/day-1/input.txt', part1(...));

function part2(string $input): int
{
    $leftList = [];
    $rightList = [];

    array_map(
        static function ($line) use (&$leftList, &$rightList) {
            $regex = '/\d+/ui';

            preg_match_all($regex, $line, $matches);

            $leftList[] = $matches[0][0];
            $rightList[] = $matches[0][1];
        },
        explode(PHP_EOL, rtrim($input, PHP_EOL)),
    );

    sort($leftList);
    sort($rightList);

    $totalSimilarityScore = 0;

    $rightCount = array_count_values($rightList);

    foreach ($leftList as $number) {
        if (isset($rightCount[$number])) {
            $countInRight = $rightCount[$number];
            $totalSimilarityScore += $number * $countInRight;
        }
    }

    return $totalSimilarityScore;
}

check('2024 Day 1 Part 2 Example', '2024/inputs/day-1/part-2-example.txt', part2(...), 31);
produce('2024 Day 1 Part 2', '2024/inputs/day-1/input.txt', part2(...));
