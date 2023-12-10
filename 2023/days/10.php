<?php

namespace AOC2023\Day10;

use RuntimeException;

function part1(string $input): int
{
    $grid = explode(PHP_EOL, trim($input, PHP_EOL));

    $start = [];

    foreach ($grid as $col => $row) {
        $start = [$col, strpos($row, 'S')];

        if ($start[1] !== false) {
            break;
        }
    }

    $loop = $queue = [$start];

    while (! empty($queue)) {
        [
            $row,
            $col,
        ] = array_shift($queue);

        $char = $grid[$row][$col];

        if (
            $row > 0
            && str_contains('S|JL', $char)
            && str_contains('|7F', $grid[$row - 1][$col])
            && ! in_array([$row - 1, $col], $loop)
        ) {
            $loop[] = $queue[] = [$row - 1, $col];
        }

        if (
            $row < count($grid) - 1
            && str_contains('S|7F', $char)
            && str_contains('|JL', $grid[$row + 1][$col])
            && ! in_array([$row + 1, $col], $loop)
        ) {
            $loop[] = $queue[] = [$row + 1, $col];
        }

        if (
            $col > 0
            && str_contains('S-J7', $char)
            && str_contains('-LF', $grid[$row][$col - 1])
            && ! in_array([$row,$col - 1], $loop)
        ) {
            $loop[] = $queue[] = [$row, $col - 1];
        }

        if (
            $col < strlen($grid[$row]) - 1
            && str_contains('S-LF', $char)
            && str_contains('-J7', $grid[$row][$col + 1])
            && ! in_array([$row, $col + 1], $loop)
        ) {
            $loop[] = $queue[] = [$row, $col + 1];
        }
    }

    return count($loop) / 2;
}

check('2023 Day 10 Part 1 Example', '2023/inputs/day-10/part-1-example.txt', part1(...), 8);
produce('2023 Day 10 Part 1', '2023/inputs/day-10/input.txt', part1(...));

function part2(string $input): int
{
    $grid = explode(PHP_EOL, trim($input, PHP_EOL));

    $start = [];

    foreach ($grid as $col => $row) {
        $start = [$col, strpos($row, 'S')];

        if ($start[1] !== false) {
            break;
        }
    }

    $loop = $queue = [$start];

    $maybe_s = ['|', '-', 'J', 'L', '7', 'F'];

    while (! empty($queue)) {
        [
            $row,
            $col,
        ] = array_shift($queue);

        $char = $grid[$row][$col];

        if (
            $row > 0
            && str_contains('S|JL', $char)
            && str_contains('|7F', $grid[$row - 1][$col])
            && ! in_array([$row - 1, $col], $loop)
        ) {
            $loop[] = $queue[] = [$row - 1, $col];

            if ('S' === $char) {
                $maybe_s = array_intersect($maybe_s, str_split('|JL'));
            }
        }

        if (
            $row < count($grid) - 1
            && str_contains('S|7F', $char)
            && str_contains('|JL', $grid[$row + 1][$col])
            && ! in_array([$row + 1, $col], $loop)
        ) {
            $loop[] = $queue[] = [$row + 1, $col];

            if ('S' === $char) {
                $maybe_s = array_intersect($maybe_s, str_split('|7F'));
            }
        }

        if (
            $col > 0
            && str_contains('S-J7', $char)
            && str_contains('-LF', $grid[$row][$col - 1])
            && ! in_array([$row,$col - 1], $loop)
        ) {
            $loop[] = $queue[] = [$row, $col - 1];

            if ('S' === $char) {
                $maybe_s = array_intersect($maybe_s, str_split('-J7'));
            }
        }

        if (
            $col < strlen($grid[$row]) - 1
            && str_contains('S-LF', $char)
            && str_contains('-J7', $grid[$row][$col + 1])
            && ! in_array([$row, $col + 1], $loop)
        ) {
            $loop[] = $queue[] = [$row, $col + 1];

            if ('S' === $char) {
                $maybe_s = array_intersect($maybe_s, str_split('-LF'));
            }
        }
    }

    $grid[$start[0]][$start[1]] = end($maybe_s);

    $grid = array_map(static function ($row) use ($grid, $loop): string {
        return implode('', array_map(static function ($char, $column) use ($row, $loop): string {
            return in_array([$row, $column], $loop) ? $char : '.';
        }, str_split($grid[$row]), array_keys(str_split($grid[$row]))));
    }, array_keys($grid));

    $outside = [];

    foreach ($grid as $r => $row) {
        $within = false;
        $up = null;

        foreach (str_split($row) as $c => $ch) {
            switch ($ch) {
                case '|':
                    $within = !$within;
                    break;

                case 'L':
                case 'F':
                    $up = ('L' === $ch);
                    break;

                case '7':
                case 'J':
                    if (($up ? 'J' : '7') !== $ch) {
                        $within = !$within;
                    }

                    $up = null;
                    break;

                default:
                    if ('-' !== $ch && '.' !== $ch) {
                        throw new RuntimeException('unexpected character (horizontal): {$ch}');
                    }
            }

            if (! $within) {
                $outside[] = [$r, $c];
            }
        }
    }

    foreach ($outside as [$row, $col]) {
        $grid[$row][$col] = 'O';
    }

    $count = 0;

    foreach ($grid as $row) {
        foreach (str_split($row) as $ch) {
            if ('.' === $ch) {
                $count++;
            }
        }
    }

    return $count;
}

check('2023 Day 10 Part 2 Example', '2023/inputs/day-10/part-2-example.txt', part2(...), 10);
produce('2023 Day 10 Part 2', '2023/inputs/day-10/input.txt', part2(...));
