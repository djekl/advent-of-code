<?php

namespace AOC2023\Day16;

use SplQueue;

function part1(string $input, $startingPosition = [0, -1, 'RIGHT']): int
{
    $grid = explode(PHP_EOL, trim($input, PHP_EOL));

    $queue = [$startingPosition];
    $seen = [];

    $checkSeen = static function (array $coordinates) use (&$queue, &$seen): void {
        if (! in_array($coordinates, $seen, true)) {
            $seen[] = $coordinates;
            $queue[] = $coordinates;
        }
    };

    while (! empty($queue)) {
        [$row, $col, $direction] = array_shift($queue);

        match ($direction) {
            'UP' => --$row,
            'RIGHT' => ++$col,
            'DOWN' => ++$row,
            'LEFT' => --$col,
        };

        if (
            $row < 0
            || $col < 0
            || $row >= count($grid)
            || $col >= strlen($grid[0])
        ) {
            continue;
        }

        $char = $grid[$row][$col];

        if (
            '.' === $char
            || ('-' === $char && in_array($direction, ['LEFT', 'RIGHT']))
            || ('|' === $char && in_array($direction, ['UP', 'DOWN']))
        ) {
            $checkSeen([
                $row,
                $col,
                $direction,
            ]);

            continue;
        }

        if ('/' === $char) {
            $checkSeen([
                $row,
                $col,
                match ($direction) {
                    'UP' => 'RIGHT',
                    'RIGHT' => 'UP',
                    'DOWN' => 'LEFT',
                    'LEFT' => 'DOWN',
                },
            ]);

            continue;
        }

        if ('\\' === $char) {
            $checkSeen([
                $row,
                $col,
                match ($direction) {
                    'UP' => 'LEFT',
                    'RIGHT' => 'DOWN',
                    'DOWN' => 'RIGHT',
                    'LEFT' => 'UP',
                },
            ]);

            continue;
        }

        $directions = '|' === $char ? ['LEFT', 'RIGHT'] : ['UP', 'DOWN'];

        foreach ($directions as $direction) {
            $checkSeen([
                $row,
                $col,
                match ($direction) {
                    'UP' => 'LEFT',
                    'RIGHT' => 'DOWN',
                    'DOWN' => 'RIGHT',
                    'LEFT' => 'UP',
                },
            ]);
        }
    }

    $seen = array_map(static function ($item) {
        return [
            $item[0],
            $item[1],
        ];
    }, $seen);
    $seen = array_unique($seen, SORT_REGULAR);

    return count($seen);
}

check('2023 Day 16 Part 1 Example', '2023/inputs/day-16/part-1-example.txt', part1(...), 46);
produce('2023 Day 16 Part 1', '2023/inputs/day-16/input.txt', part1(...));

function part2(string $input): int
{
    $grid = explode(PHP_EOL, trim($input, PHP_EOL));
    $maxCount = 0;

    foreach (['RIGHT', 'DOWN', 'LEFT', 'UP'] as $direction) {
        if (in_array($direction, ['UP', 'DOWN'])) {
            $max = count($grid);

            for ($col = 0; $col < $max; $col++) {
                $maxCount = max($maxCount, part1($input, [
                    'DOWN' === $direction ? 0 : count($grid) - 1,
                    $col,
                    $direction,
                ]));
            }
        }

        if (in_array($direction, ['UP', 'DOWN'])) {
            $max = strlen($grid[0]);

            for ($row = 0; $row < $max; $row++) {
                $maxCount = max($maxCount, part1($input, [
                    'RIGHT' === $direction ? 0 : strlen($grid[0]) - 1,
                    $row,
                    $direction,
                ]));
            }
        }
    }

    return $maxCount;
}

check('2023 Day 16 Part 1 Test Example ([0, 3, \'DOWN\'])', ['2023/inputs/day-16/part-2-example.txt', [0, 3, 'DOWN']], part1(...), 51);
check('2023 Day 16 Part 2 Example', ['2023/inputs/day-16/part-2-example.txt'], part2(...), 51);
produce('2023 Day 16 Part 2', '2023/inputs/day-16/input.txt', part2(...));
