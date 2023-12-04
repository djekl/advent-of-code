<?php

namespace AOC2015\Day8;

function part1(string $input): int
{
    $totalCodeCharacters = 0;
    $totalMemoryCharacters = 0;

    foreach (explode(PHP_EOL, $input) as $line) {
        if ('' === $line) {
            continue;
        }

        $totalCodeCharacters += strlen($line);
        $inMemoryString = stripcslashes($line);
        $totalMemoryCharacters += strlen($inMemoryString) - 2;
    }

    return $totalCodeCharacters - $totalMemoryCharacters;
}

check('2015 Day 8 Part 1 Example', '2015/inputs/day-8/input.txt', part1(...), 1333);
produce('2015 Day 8 Part 1', '2015/inputs/day-8/input.txt', part1(...));

function part2(string $input): int
{
    $totalCodeCharacters = 0;
    $totalEncodedCharacters = 0;

    foreach (explode(PHP_EOL, $input) as $line) {
        if ('' === $line) {
            continue;
        }

        $totalCodeCharacters += strlen($line);
        $encodedString = addcslashes($line, '\"\\');
        $totalEncodedCharacters += strlen($encodedString) + 2;
    }

    return $totalEncodedCharacters - $totalCodeCharacters;
}

check('2015 Day 8 Part 2 Example', '2015/inputs/day-8/input.txt', part2(...), 2046);
produce('2015 Day 8 Part 2', '2015/inputs/day-8/input.txt', part2(...));
