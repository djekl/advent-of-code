<?php

namespace AOC2023\Day11;

use Closure;

function part1(string $input): int
{
    $grid = explode(PHP_EOL, trim($input, PHP_EOL));

    $empty_rows = array_filter(array_keys($grid), function ($row) use ($grid) {
        return str_repeat('.', count($grid)) === $grid[$row];
    });

    $empty_cols = array_filter(array_keys(str_split($grid[0])), function ($col) use ($grid) {
        return str_repeat('.', count($grid)) === implode('', array_column(array_map('str_split', $grid), $col));
    });

    $galaxies = [];

    foreach ($grid as $row => $line) {
        foreach (str_split($line) as $col => $char) {
            if ($char === '#') {
                $galaxies[] = [$row, $col];
            }
        }
    }

    $sum = 0;

    foreach ($galaxies as $index => [$galaxy_row, $galaxy_col]) {
        foreach (array_slice($galaxies, 0, $index) as $g => [$row, $col]) {
            for ($i = min($galaxy_row, $row); $i < max($galaxy_row, $row); $i++) {
                $sum += in_array($i, $empty_rows) ? 2 : 1;
            }

            for ($i = min($galaxy_col, $col); $i < max($galaxy_col, $col); $i++) {
                $sum += in_array($i, $empty_cols) ? 2 : 1;
            }
        }
    }

    return $sum;
}

check('2023 Day 11 Part 1 Example', '2023/inputs/day-11/part-1-example.txt', part1(...), 374);
check('2023 Day 11 Part 1 Example', '2023/inputs/day-11/input.txt', part1(...), 9734203);
// produce('2023 Day 11 Part 1', '2023/inputs/day-11/input.txt', part1(...));

function part2(string $input, $factor = 1000000): int
{
    $grid = explode(PHP_EOL, trim($input, PHP_EOL));

    $empty_rows = array_filter(array_keys($grid), function ($row) use ($grid) {
        return str_repeat('.', count($grid)) === $grid[$row];
    });

    $empty_cols = array_filter(array_keys(str_split($grid[0])), function ($col) use ($grid) {
        return str_repeat('.', count($grid)) === implode('', array_column(array_map('str_split', $grid), $col));
    });

    $galaxies = [];

    foreach ($grid as $row => $line) {
        foreach (str_split($line) as $col => $char) {
            if ($char === '#') {
                $galaxies[] = [$row, $col];
            }
        }
    }

    $sum = 0;

    foreach ($galaxies as $index => [$galaxy_row, $galaxy_col]) {
        foreach (array_slice($galaxies, 0, $index) as $g => [$row, $col]) {
            for ($i = min($galaxy_row, $row); $i < max($galaxy_row, $row); $i++) {
                $sum += in_array($i, $empty_rows) ? $factor : 1;
            }

            for ($i = min($galaxy_col, $col); $i < max($galaxy_col, $col); $i++) {
                $sum += in_array($i, $empty_cols) ? $factor : 1;
            }
        }
    }

    return $sum;
}

check('2023 Day 11 Part 2 Example 2x', ['2023/inputs/day-11/part-2-example.txt', 2], part2(...), 374);
check('2023 Day 11 Part 2 Example 10x', ['2023/inputs/day-11/part-2-example.txt', 10], part2(...), 1030);
check('2023 Day 11 Part 2 Example 100x', ['2023/inputs/day-11/part-2-example.txt', 100], part2(...), 8410);
// produce('2023 Day 11 Part 2', ['2023/inputs/day-11/input.txt', 1000000], part2(...));
