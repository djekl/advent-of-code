<?php

namespace AOC2023\Day8;

function part1(string $input): int
{
    $lines = explode(PHP_EOL, trim($input, PHP_EOL));
    $instructions = str_split(array_shift($lines));
    array_shift($lines); // blank line
    $map = [];

    foreach ($lines as $i => $line) {
        $line = explode(' = ', $line);
        $map[$line[0]] = explode(', ', str_replace([
            '(',
            ')',
        ], '', $line[1]));

        unset($lines[$i]);
    }
    unset($lines);

    $currentKey = 'AAA';
    $moves = 0;

    while ($currentKey !== 'ZZZ') {
        $moves++;
        $instruction = $instructions[($moves - 1) % count($instructions)];
        $currentKey = $map[$currentKey][$instruction === 'R' ? 1 : 0];
    }

    return $moves;
}

check('2023 Day 8 Part 1 Example 1', '2023/inputs/day-8/part-1-example.txt', part1(...), 2);
check('2023 Day 8 Part 1 Example 2', '2023/inputs/day-8/part-1-example-2.txt', part1(...), 6);
// produce('2023 Day 8 Part 1', '2023/inputs/day-8/input.txt', part1(...));

function part2(string $input): int
{
    $lines = explode(PHP_EOL, trim($input, PHP_EOL));
    $instructions = str_split(array_shift($lines));
    array_shift($lines); // blank line
    $map = [];

    foreach ($lines as $i => $line) {
        $line = explode(' = ', $line);
        $map[$line[0]] = explode(', ', str_replace([
            '(',
            ')',
        ], '', $line[1]));

        unset($lines[$i]);
    }
    unset($lines);

    $keyValues = [];

    foreach (array_filter(array_keys($map), static fn ($key) => str_ends_with($key, 'A')) as $currentKey) {
        $startingKey = $currentKey;
        $moves = 0;

        while (! str_ends_with($currentKey, 'Z')) {
            $moves++;

            $instruction = $instructions[($moves - 1) % count($instructions)];
            $currentKey = $map[$currentKey][$instruction === 'R' ? 1 : 0];
        }

        $keyValues[$startingKey] = $moves;
    }

    $output = array_shift($keyValues);

    foreach ($keyValues as $value) {
        $output = gmp_lcm($output, $value);
    }

    return gmp_intval($output);
}

check('2023 Day 8 Part 2 Example', '2023/inputs/day-8/part-2-example.txt', part2(...), 6);
// produce('2023 Day 8 Part 2', '2023/inputs/day-8/input.txt', part2(...));
