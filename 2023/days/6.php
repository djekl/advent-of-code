<?php

namespace AOC2023\Day6;

function part1(string $input): int
{
    $input = preg_replace('/( +)/u', ' ', $input);

    [
        $times,
        $distances,
    ] = explode("\n", trim($input));

    $times = explode(' ', explode(': ', $times)[1]);
    $distances = explode(' ', explode(': ', $distances)[1]);

    $result = 1;

    foreach ($times as $i => $time) {
        $time = (int) $times[$i];
        $distance = (int) $distances[$i];
        $ways = 0;

        for ($journey = 0; $journey < $time; $journey++) {
            $max_distance = $journey * ($time - $journey);

            if ($max_distance > $distance) {
                $ways++;
            }
        }

        $result *= $ways;
    }

    return $result;
}

check('2023 Day 6 Part 1 Example', '2023/inputs/day-6/part-1-example.txt', part1(...), 288);
// produce('2023 Day 6 Part 1', '2023/inputs/day-6/input.txt', part1(...));

function part2(string $input): int
{
    $input = preg_replace('/( +)/u', '', $input);

    [
        $time,
        $distance,
    ] = explode("\n", trim($input));

    $time = (int) explode(':', $time)[1];
    $distance = (int) explode(':', $distance)[1];

    $ways = 0;

    for ($journey = 0; $journey < $time; $journey++) {
        $max_distance = $journey * ($time - $journey);

        if ($max_distance > $distance) {
            $ways++;
        }
    }

    return $ways;
}

check('2023 Day 6 Part 2 Example', '2023/inputs/day-6/part-2-example.txt', part2(...), 71503);
// produce('2023 Day 6 Part 2', '2023/inputs/day-6/input.txt', part2(...));
