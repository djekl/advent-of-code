<?php

namespace AOC2023\Day17;

use Fiber;
use RedisException;

function outOfBounds(array $grid, int $row, int $col): bool {
    return (
        ($row < 0 || $row > count($grid) - 1)
        || ($col < 0 || $col > count($grid[0]) - 1)
    );
}

function part1(string $input): int {
    $grid = array_map('str_split', explode(PHP_EOL, trim($input, PHP_EOL)));

    try {
        $redis = redisInstance();
    } catch (RedisException $e) {
        die("No Redis instance found. {$e->getMessage()}.");
    }

    $seenListKey = '2023:day-17:part-1:seen';
    $queueKey = '2023:day-17:part-1:queue';

    $redis->del($seenListKey, $queueKey);

    $redis->zAdd(
        $queueKey,
        0,
        json_encode([0, 0, 0, 0, 0, 0])
    );

    $fibers = [];

    while ($redis->zCount($queueKey, '-inf', 'inf') > 0) {
        for ($i = 0; $i < $redis->zCount($queueKey, '-inf', 'inf'); $i++) {
            $fiberInput = array_keys($redis->zPopMin($queueKey))[0];

            $fibers[$fiberInput] = new Fiber(function(array $input) use ($redis, $grid, $queueKey, $seenListKey): ?int {
                [
                    $heatLoss,
                    $row,
                    $col,
                    $directionRow,
                    $directionCol,
                    $numberOfTimes,
                ] = $input;

                if (
                    count($grid) - 1 === $row
                    && count($grid[0]) - 1 === $col
                ) {
                    return $heatLoss;
                }

                $current = [$row, $col, $directionRow, $directionCol, $numberOfTimes];

                if ($redis->sIsMember($seenListKey, json_encode($current))) {
                    return null;
                }

                $redis->sAdd($seenListKey, json_encode($current));

                if (
                    3 > $numberOfTimes
                    && [0, 0] !== [$directionRow, $directionCol]
                ) {
                    $newRow = $row + $directionRow;
                    $newCol = $col + $directionCol;

                    if (! outOfBounds($grid, $newRow, $newCol)) {
                        $redis->zAdd(
                            $queueKey,
                            ($heatLoss + $grid[$newRow][$newCol]),
                            json_encode([
                                $heatLoss + $grid[$newRow][$newCol],
                                $newRow,
                                $newCol,
                                $directionRow,
                                $directionCol,
                                $numberOfTimes + 1,
                            ])
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
                            $redis->zAdd(
                                $queueKey,
                                ($heatLoss + $grid[$newRow][$newCol]),
                                json_encode([
                                    $heatLoss + $grid[$newRow][$newCol],
                                    $newRow,
                                    $newCol,
                                    $newDirectionRow,
                                    $newDirectionCol,
                                    1,
                                ])
                            );
                        }
                    }
                }

                return null;
            });
            $fibers[$fiberInput]->start(json_decode($fiberInput));
        }
    }

    while (count($fibers) > 0) {
        foreach ($fibers as $fiberInput => $fiber) {
            if ($fiber->isSuspended()) {
                $fiber->resume(json_decode($fiberInput));
            }

            if ($fiber->isTerminated()) {
                if (null !== $fiber->getReturn()) {
                    return $fiber->getReturn();
                }

                unset($fibers[$fiberInput]);
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

    try {
        $redis = redisInstance();
    } catch (RedisException $e) {
        die("No Redis instance found. {$e->getMessage()}.");
    }

    $seenListKey = '2023:day-17:part-1:seen';
    $queueKey = '2023:day-17:part-1:queue';

    $redis->del($seenListKey, $queueKey);

    $redis->zAdd(
        $queueKey,
        0,
        json_encode([0, 0, 0, 0, 0, 0])
    );

    $fibers = [];

    while ($redis->zCount($queueKey, '-inf', 'inf') > 0) {
        for ($i = 0; $i < $redis->zCount($queueKey, '-inf', 'inf'); $i++) {
            $fiberInput = array_keys($redis->zPopMin($queueKey))[0];

            $fibers[$fiberInput] = new Fiber(function(array $input) use ($redis, $grid, $queueKey, $seenListKey): ?int {
                [
                    $heatLoss,
                    $row,
                    $col,
                    $directionRow,
                    $directionCol,
                    $numberOfTimes,
                ] = $input;

                if (
                    $numberOfTimes >= 4
                    && count($grid) - 1 === $row
                    && count($grid[0]) - 1 === $col
                ) {
                    return $heatLoss;
                }

                $current = [$row, $col, $directionRow, $directionCol, $numberOfTimes];

                if ($redis->sIsMember($seenListKey, json_encode($current))) {
                    return null;
                }

                $redis->sAdd($seenListKey, json_encode($current));

                if (
                    $numberOfTimes < 10
                    && [0, 0] !== [$directionRow, $directionCol]
                ) {
                    $newRow = $row + $directionRow;
                    $newCol = $col + $directionCol;

                    if (! outOfBounds($grid, $newRow, $newCol)) {
                        $redis->zAdd(
                            $queueKey,
                            ($heatLoss + $grid[$newRow][$newCol]),
                            json_encode([
                                $heatLoss + $grid[$newRow][$newCol],
                                $newRow,
                                $newCol,
                                $directionRow,
                                $directionCol,
                                $numberOfTimes + 1,
                            ])
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
                                $redis->zAdd(
                                    $queueKey,
                                    ($heatLoss + $grid[$newRow][$newCol]),
                                    json_encode([
                                        $heatLoss + $grid[$newRow][$newCol],
                                        $newRow,
                                        $newCol,
                                        $newDirectionRow,
                                        $newDirectionCol,
                                        1,
                                    ])
                                );
                            }
                        }
                    }
                }


                return null;
            });
            $fibers[$fiberInput]->start(json_decode($fiberInput));
        }
    }

    while (count($fibers) > 0) {
        foreach ($fibers as $fiberInput => $fiber) {
            if ($fiber->isSuspended()) {
                $fiber->resume(json_decode($fiberInput));
            }

            if ($fiber->isTerminated()) {
                if (null !== $fiber->getReturn()) {
                    return $fiber->getReturn();
                }

                unset($fibers[$fiberInput]);
            }
        }
    }

    return 0;
}

check('2023 Day 17 Part 2 Example 1', '2023/inputs/day-17/part-2-example-1.txt', part2(...), 94);
check('2023 Day 17 Part 2 Example 2', '2023/inputs/day-17/part-2-example-2.txt', part2(...), 71);
produce('2023 Day 17 Part 2', '2023/inputs/day-17/input.txt', part2(...));
