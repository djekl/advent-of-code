<?php

namespace AOC2015\Day10;

function part1(string $input): int
{
    $result = trim($input, PHP_EOL);

    for ($i = 0; $i < 40; $i++) {
        $result = preg_replace_callback(
            '/(.)\1*/',
            fn ($matches) => strlen($matches[0]) . $matches[1],
            $result,
        );
    }

    return strlen($result);
}

check('2015 Day 10 Part 1 Example', '2015/inputs/day-10/input.txt', part1(...), 360154);
// produce('2015 Day 10 Part 1', '2015/inputs/day-10/input.txt', part1(...));

function part2(string $input): int
{
    $result = trim($input, PHP_EOL);

    for ($i = 0; $i < 50; $i++) {
        $result = preg_replace_callback(
            '/(.)\1*/',
            fn ($matches) => strlen($matches[0]) . $matches[1],
            $result,
        );
    }

    return strlen($result);
}

check('2015 Day 10 Part 2 Example', '2015/inputs/day-10/input.txt', part2(...), 5103798);
// produce('2015 Day 10 Part 2', '2015/inputs/day-10/input.txt', part2(...));
