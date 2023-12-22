<?php

namespace AOC2015\Day1;

function part1(string $input): int
{
    $input = trim($input, PHP_EOL);

    $floor = 0;

    foreach (str_split($input) as $char) {
        if ($char === '(') {
            $floor++;
        } elseif ($char === ')') {
            $floor--;
        }
    }

    return $floor;
}

check('2015 Day 1 Part 1 Example', '2015/inputs/day-1/part-1-example.txt', part1(...), 1);
// produce('2015 Day 1 Part 1', '2015/inputs/day-1/input.txt', part1(...));

function part2(string $input): int
{
    $input = trim($input, PHP_EOL);

    $floor = 0;

    foreach (str_split($input) as $count => $char) {
        if ($char === '(') {
            $floor++;
        } elseif ($char === ')') {
            $floor--;
        }

        if ($floor === -1) {
            return $count + 1;
        }
    }

    return $floor;
}

check('2015 Day 1 Part 2 Example', '2015/inputs/day-1/part-2-example.txt', part2(...), 0);
// produce('2015 Day 1 Part 2', '2015/inputs/day-1/input.txt', part2(...));
