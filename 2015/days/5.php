<?php

namespace AOC2015\Day5;

function part1(string $input): int
{
    $lines = explode(PHP_EOL, $input);

    $niceStrings = 0;

    foreach ($lines as $line) {
        if ('' === $line) {
            continue;
        }

        if (
            preg_match('/(.*[aeiou].*){3,}/', $line)
            && preg_match('/(.)\1/', $line)
            && ! preg_match('/(ab|cd|pq|xy)/', $line)
        ) {
            $niceStrings++;
        }
    }

    return $niceStrings;
}

check('2015 Day 5 Part 1 Example', '2015/inputs/day-5/part-1-example.txt', part1(...), 2);
// produce('2015 Day 5 Part 1', '2015/inputs/day-5/input.txt', part1(...));

function part2(string $input): int
{
    $lines = explode(PHP_EOL, $input);

    $niceStrings = 0;

    foreach ($lines as $line) {
        if ('' === $line) {
            continue;
        }

        if (
            preg_match('/(..).*\1/', $line) // It contains a pair of any two letters that appears at least twice in the string without overlapping
            && preg_match('/(.).\1/', $line) // It contains at least one letter which repeats with exactly one letter between them
        ) {
            $niceStrings++;
        }
    }

    return $niceStrings;
}

check('2015 Day 5 Part 2 Example', '2015/inputs/day-5/part-2-example.txt', part2(...), 2);
// produce('2015 Day 5 Part 2', '2015/inputs/day-5/input.txt', part2(...));
