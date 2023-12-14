<?php

namespace AOC2023\Day14;

function part1(string $input): int
{
    $lines = explode(PHP_EOL, trim($input, PHP_EOL));

    $lines = array_map(null, ...array_map('str_split', $lines));
    $lines = array_map(static fn (array $array): string => implode('', $array), $lines);

    foreach ($lines as $i => $column) {
        $lines[$i] = implode('#', array_map(static function (string $section): string {
            $arr = str_split($section);
            rsort($arr);

            return implode('', $arr);
        }, explode('#', $column)));
    }

    $lines = array_map(null, ...array_map('str_split', $lines));
    $lines = array_map(static fn (array $array): string => implode('', $array), $lines);

    $total = 0;

    foreach (array_reverse($lines) as $i => $column) {
        $total += ($i + 1) * substr_count($column, 'O');
    }

    return $total;
}

check('2023 Day 14 Part 1 Example', '2023/inputs/day-14/part-1-example.txt', part1(...), 136);
check('2023 Day 14 Part 1', '2023/inputs/day-14/input.txt', part1(...), 105249);
produce('2023 Day 14 Part 1', '2023/inputs/day-14/input.txt', part1(...));

// function part2(string $input): int
// {
//     //
// }

// check('2023 Day 14 Part 2 Example', '2023/inputs/day-14/part-2-example.txt', part2(...), null);
// check('2023 Day 14 Part 2', '2023/inputs/day-14/input.txt', part2(...), 88680);
// produce('2023 Day 14 Part 2', '2023/inputs/day-14/input.txt', part2(...));
