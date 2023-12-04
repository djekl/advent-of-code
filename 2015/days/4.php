<?php

namespace AOC2015\Day4;

function part1(string $input): int
{
    $input = trim($input, PHP_EOL);

    $number = 1;
    while (true) {
        $hash = md5($input . $number);

        if (str_starts_with($hash, '00000')) {
            return $number;
        }

        $number++;
    }
}

check('2015 Day 4 Part 1 Example', 'abcdef', part1(...), 609043);
check('2015 Day 4 Part 1 Example', 'pqrstuv', part1(...), 1048970);
produce('2015 Day 4 Part 1', '2015/inputs/day-4/input.txt', part1(...));

function part2(string $input): int
{
    $input = trim($input, PHP_EOL);

    $number = 1;
    while (true) {
        $hash = md5($input . $number);

        if (str_starts_with($hash, '000000')) {
            return $number;
        }

        $number++;
    }
}

produce('2015 Day 4 Part 2', '2015/inputs/day-4/input.txt', part2(...));
