<?php

namespace AOC2023\Day17;

function outOfBounds(array $grid, int $row, int $col): bool {
    return (
        ($row < 0 || $row > count($grid) - 1)
        || ($col < 0 || $col > count($grid[0]) - 1)
    );
}

function part1(string $input): int {
    $grid = array_map('str_split', explode(PHP_EOL, trim($input, PHP_EOL)));

    $seen = [];

    $queue = new \SplPriorityQueue();
    $queue->insert(
        value: [0, 0, 0, 0, 0, 0],
        priority: 0
    );

    while (! $queue->isEmpty()) {
        [
            $heatLoss,
            $row,
            $col,
            $directionRow,
            $directionCol,
            $numberOfTimes,
        ] = $queue->extract();

        if (count($grid) - 1 === $row && count($grid[0]) - 1 === $col) {
            return $heatLoss;
        }

        $current = [$row, $col, $directionRow, $directionCol, $numberOfTimes];

        if (in_array($current, $seen, true)) {
            continue;
        }

        $seen[] = $current;

        if (
            3 > $numberOfTimes
            && [0, 0] !== [$directionRow, $directionCol]
        ) {
            $newRow = $row + $directionRow;
            $newCol = $col + $directionCol;

            if (! outOfBounds($grid, $newRow, $newCol)) {
                $queue->insert(
                    value: [
                        $heatLoss + $grid[$newRow][$newCol],
                        $newRow,
                        $newCol,
                        $directionRow,
                        $directionCol,
                        $numberOfTimes + 1,
                    ],
                    priority: -$heatLoss - $grid[$newRow][$newCol]
                );
            }
        }

        foreach (['TOP', 'RIGHT', 'BOTTOM', 'LEFT'] as $direction) {
            [$newDirectionRow, $newDirectionCol] = match ($direction) {
                'TOP' => [-1, 0],
                'RIGHT' => [0, 1],
                'BOTTOM' => [1, 0],
                'LEFT' => [0, -1],
            };

            if (
                [$newDirectionRow, $newDirectionCol] !== [$directionRow, $directionCol]
                && [$newDirectionRow, $newDirectionCol] !== [-$directionRow, -$directionCol]
            ) {
                $newRow = $row + $newDirectionRow;
                $newCol = $col + $newDirectionCol;

                if (! outOfBounds($grid, $newRow, $newCol)) {
                    $queue->insert(
                        value: [
                            $heatLoss + $grid[$newRow][$newCol],
                            $newRow,
                            $newCol,
                            $newDirectionRow,
                            $newDirectionCol,
                            1,
                        ],
                        priority: -$heatLoss - $grid[$newRow][$newCol]
                    );
                }
            }
        }
    }

    return 0;
}

check('2023 Day 17 Part 1 Example', '2023/inputs/day-17/part-1-example.txt', part1(...), 102);
produce('2023 Day 17 Part 1', '2023/inputs/day-17/input.txt', part1(...));

function part2(string $input): int
{
    $grid = array_map('str_split', explode(PHP_EOL, trim($input, PHP_EOL)));

    $seen = [];

    $queue = new \SplPriorityQueue();
    $queue->insert(
        value: [0, 0, 0, 0, 0, 0],
        priority: 0
    );

    while (! $queue->isEmpty()) {
        [
            $heatLoss,
            $row,
            $col,
            $directionRow,
            $directionCol,
            $numberOfTimes,
        ] = $queue->extract();

        if (
            $numberOfTimes >= 4
            && count($grid) - 1 === $row
            && count($grid[0]) - 1 === $col
        ) {
            return $heatLoss;
        }

        $current = [$row, $col, $directionRow, $directionCol, $numberOfTimes];

        if (in_array($current, $seen, true)) {
            continue;
        }

        $seen[] = $current;

        if (
            $numberOfTimes < 10
            && [0, 0] !== [$directionRow, $directionCol]
        ) {
            $newRow = $row + $directionRow;
            $newCol = $col + $directionCol;

            if (! outOfBounds($grid, $newRow, $newCol)) {
                $queue->insert(
                    value: [
                        $heatLoss + $grid[$newRow][$newCol],
                        $newRow,
                        $newCol,
                        $directionRow,
                        $directionCol,
                        $numberOfTimes + 1,
                    ],
                    priority: -$heatLoss - $grid[$newRow][$newCol]
                );
            }
        }

        if (
            $numberOfTimes >= 4
            || [0, 0] === [$directionRow, $directionCol]
        ) {
            foreach (['TOP', 'RIGHT', 'BOTTOM', 'LEFT'] as $direction) {
                [$newDirectionRow, $newDirectionCol] = match ($direction) {
                    'TOP' => [-1, 0],
                    'RIGHT' => [0, 1],
                    'BOTTOM' => [1, 0],
                    'LEFT' => [0, -1],
                };

                if (
                    [$newDirectionRow, $newDirectionCol] !== [$directionRow, $directionCol]
                    && [$newDirectionRow, $newDirectionCol] !== [-$directionRow, -$directionCol]
                ) {
                    $newRow = $row + $newDirectionRow;
                    $newCol = $col + $newDirectionCol;

                    if (! outOfBounds($grid, $newRow, $newCol)) {
                        $queue->insert(
                            value: [
                                $heatLoss + $grid[$newRow][$newCol],
                                $newRow,
                                $newCol,
                                $newDirectionRow,
                                $newDirectionCol,
                                1,
                            ],
                            priority: -$heatLoss - $grid[$newRow][$newCol]
                        );
                    }
                }
            }
        }
    }

    return 0;
}

check('2023 Day 17 Part 2 Example', '2023/inputs/day-17/part-2-example-1.txt', part2(...), 94);
check('2023 Day 17 Part 2 Example', '2023/inputs/day-17/part-2-example-2.txt', part2(...), 71);
produce('2023 Day 17 Part 2', '2023/inputs/day-17/input.txt', part2(...));
