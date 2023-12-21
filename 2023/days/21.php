<?php

namespace AOC2023\Day21;

function part1(string $input, int $availableSteps): int
{
    $grid = explode(PHP_EOL, trim($input, PHP_EOL));

    $startRow = $startCol = null;

    foreach ($grid as $row => $line) {
        if (! str_contains($line, 'S')) {
            continue;
        }

        foreach (str_split($line) as $col => $ch) {
            if ($ch === 'S') {
                $startRow = $row;
                $startCol = $col;

                break 2;
            }
        }
    }

    $gardenPlots = [];
    $seen = [[$startRow, $startCol]];

    $queue = [[$startRow, $startCol, $availableSteps]];

    while (! empty($queue)) {
        [$row, $col, $availableSteps] = array_shift($queue);

        if (0 === $availableSteps % 2) {
            $gardenPlots[] = [$row, $col];
        }

        if (0 === $availableSteps) {
            continue;
        }

        foreach ([
            [$row + 1, $col],
            [$row - 1, $col],
            [$row, $col + 1],
            [$row, $col - 1]
        ] as $position) {
            [$newRow, $newCol] = $position;

            if (
                '#' === $grid[$newRow][$newCol]
                || in_array([$newRow, $newCol], $seen)
                || $newRow < 0
                || $newCol < 0
                || $newRow >= count($grid)
                || $newCol >= strlen($grid[0])
            ) {
                continue;
            }

            $seen[] = [$newRow, $newCol];
            $queue[] = [$newRow, $newCol, $availableSteps - 1];
        }
    }

    return count($gardenPlots);
}

check('2023 Day 21 Part 1 Example (6 steps)', ['2023/inputs/day-21/part-1-example.txt', 6], part1(...), 16);
produce('2023 Day 21 Part 1 (64 steps)', ['2023/inputs/day-21/input.txt', 64], part1(...));

function part2(string $input): int
{
    //
}

// check('2023 Day 21 Part 2 Example', '2023/inputs/day-21/part-2-example.txt', part1(...), null);
// produce('2023 Day 21 Part 2', '2023/inputs/day-21/input.txt', part2(...));
