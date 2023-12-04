<?php

namespace AOC2015\Day12;

function part1(string|array|object $input): int|string
{
    if (
        ! is_numeric($input)
        && ! is_array($input)
        && ! is_object($input)
    ) {
        $input = json_decode($input);
    }

    if (is_numeric($input)) {
        return $input;
    }

    if (is_array($input) || is_object($input)) {
        $sum = 0;

        foreach ($input as $item) {
            $sum += part1($item);
        }

        return $sum;
    }

    return 0;
}

check('2015 Day 12 Part 1 Example', '2015/inputs/day-12/input.txt', part1(...), 119433);
produce('2015 Day 12 Part 1', '2015/inputs/day-12/input.txt', part1(...));

function part2(string|array|object $input): int|string
{
    if (
        ! is_numeric($input)
        && ! is_array($input)
        && ! is_object($input)
    ) {
        $input = json_decode($input);
    }

    if (is_numeric($input)) {
        return $input;
    }

    if (is_array($input)) {
        $sum = 0;
        foreach ($input as $item) {
            $sum += part2($item);
        }
        return $sum;
    }

    if (is_object($input)) {
        foreach ($input as $property) {
            if ($property === 'red') {
                return 0;
            }
        }

        $sum = 0;

        foreach ($input as $property) {
            $sum += part2($property);
        }

        return $sum;
    }

    return 0;
}

check('2015 Day 12 Part 2 Example', '2015/inputs/day-12/input.txt', part2(...), 68466);
produce('2015 Day 12 Part 2', '2015/inputs/day-12/input.txt', part2(...));
