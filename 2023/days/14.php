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

function part2(string $input): int
{
    $lines = explode(PHP_EOL, trim($input, PHP_EOL));

    $cycleGrid = static function (array $grid): array {
        foreach (range(1, 4) as $ignored) {
            $grid = array_map(null, ...array_map('str_split', $grid));
            $grid = array_map(static fn (array $array): string => implode('', $array), $grid);

            foreach ($grid as $i => $column) {
                $grid[$i] = implode('#', array_map(static function (string $section): string {
                    $arr = str_split($section);
                    rsort($arr);

                    return implode('', $arr);
                }, explode('#', $column)));

                $grid[$i] = strrev($grid[$i]);
            }
        }

        return $grid;
    };

    $seen = [$lines];
    $iterations = 0;

    while (true) {
        $iterations++;
        $lines = $cycleGrid($lines);

        if (in_array($lines, $seen, true)) {
            $startOfLoop = array_search($lines, $seen, true);
            break;
        }

        $seen[$iterations] = $lines;
    }

    $seekIndex = (1000000000 - $startOfLoop) % ($iterations - $startOfLoop) + $startOfLoop;

    if (! array_key_exists($seekIndex, $seen)) {
        throw new \Exception('Seek index not found');
    }

    $total = 0;

    foreach (array_reverse($seen[$seekIndex]) as $i => $column) {
        $total += ($i + 1) * substr_count($column, 'O');
    }

    return $total;
}

check('2023 Day 14 Part 2 Example', '2023/inputs/day-14/part-2-example.txt', part2(...), 64);
check('2023 Day 14 Part 2', '2023/inputs/day-14/input.txt', part2(...), 88680);
produce('2023 Day 14 Part 2', '2023/inputs/day-14/input.txt', part2(...));
