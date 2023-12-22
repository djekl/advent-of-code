<?php

namespace AOC2023\Day1;

function part1(string $input): int
{
    $values = array_map(
        function ($line) {
            $regex = '/\d/ui';

            preg_match($regex, $line, $first);
            preg_match($regex, strrev($line), $last);

            if (! isset($first[0])) {
                return 0;
            }

            $first = $first[0];
            $last = $last[0];

            return (int) "{$first}{$last}";
        },
        explode(PHP_EOL, $input),
    );

    return array_sum($values);
}

check('2023 Day 1 Part 1 Example', '2023/inputs/day-1/part-1-example.txt', part1(...), 142);
// produce('2023 Day 1 Part 1', '2023/inputs/day-1/input.txt', part1(...));

function part2(string $input): int
{
    $numbers = [
        1 => "one",
        2 => "two",
        3 => "three",
        4 => "four",
        5 => "five",
        6 => "six",
        7 => "seven",
        8 => "eight",
        9 => "nine",
    ];

    $values = array_map(
        function ($line) use ($numbers) {
            $numbersReversed = array_map(
                fn ($number) => strrev($number),
                $numbers,
            );

            $regex = '/\d|(' . implode(")|(", $numbers) . ')/uis';
            $regexReversed = '/\d|(' . implode(")|(", $numbersReversed) . ')/uis';

            preg_match($regex, $line, $first);
            preg_match($regexReversed, strrev($line), $last);

            if (! isset($first[0])) {
                return 0;
            }

            $first = str_replace(
                array_values($numbers),
                array_keys($numbers),
                $first[0],
            );

            $last = $last[0];
            $last = strrev((string) $last);
            $last = str_replace(
                array_values($numbers),
                array_keys($numbers),
                $last,
            );

            return (int) "{$first}{$last}";
        },
        explode(PHP_EOL, $input),
    );

    return array_sum($values);
}

check('2023 Day 1 Part 2 Example', '2023/inputs/day-1/part-2-example.txt', part2(...), 281);
// produce('2023 Day 1 Part 2', '2023/inputs/day-1/input.txt', part2(...));
