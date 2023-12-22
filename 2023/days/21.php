<?php

namespace AOC2023\Day21;

function findGardenPlots(array $grid, int $startRow, int $startCol, int $availableSteps): int
{
    $gardenPlots = [];
    $seen = [[$startRow, $startCol]];
    $queue = [[$startRow, $startCol, $availableSteps]];

    $rowCount = count($grid);
    $colCount = strlen($grid[0]);

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

            // Wrap the indices around to the other side of the grid if they go out of bounds
            $newRow = ($newRow + $rowCount) % $rowCount;
            $newCol = ($newCol + $colCount) % $colCount;

            if (
                '#' === $grid[$newRow][$newCol]
                || in_array([$newRow, $newCol], $seen)
            ) {
                continue;
            }

            $seen[] = [$newRow, $newCol];
            $queue[] = [$newRow, $newCol, $availableSteps - 1];
        }
    }

    return count($gardenPlots);
}

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

    return findGardenPlots($grid, $startRow, $startCol, $availableSteps);
}

check('2023 Day 21 Part 1 Example (6 steps)', ['2023/inputs/day-21/part-1-example.txt', 6], part1(...), 16);
// produce('2023 Day 21 Part 1 (64 steps)', ['2023/inputs/day-21/input.txt', 64], part1(...));

function part2(string $input, int $availableSteps): int
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

    // return findGardenPlots($grid, $startRow, $startCol, $availableSteps);

    $gridWidth = (int) ($availableSteps / count($grid) - 1);

    $odd = (int) (($gridWidth / 2 * 2 + 1) ** 2);
    $even = (int) ((($gridWidth + 1) / 2 * 2) ** 2);

    $oddPoints = findGardenPlots($grid, $startRow, $startCol, count($grid) * 2 + 1);
    $evenPoints = findGardenPlots($grid, $startRow, $startCol, count($grid) * 2);

    $corners = findGardenPlots($grid, count($grid) - 1, $startCol, count($grid) - 1);
    $corners += findGardenPlots($grid, $startRow, 0, count($grid) - 1);
    $corners += findGardenPlots($grid, 0, $startCol, count($grid) - 1);
    $corners += findGardenPlots($grid, $startRow, count($grid) - 1, count($grid) - 1);

    $small = findGardenPlots($grid, count($grid) - 1, 0, (int) (count($grid) / 2 - 1));
    $small += findGardenPlots($grid, count($grid) - 1, count($grid) - 1, (int) (count($grid) / 2 - 1));
    $small += findGardenPlots($grid, 0, 0, (int) (count($grid) / 2 - 1));
    $small += findGardenPlots($grid, 0, count($grid) - 1, (int) (count($grid) / 2 - 1));

    $large = findGardenPlots($grid, count($grid) - 1, 0, (int) (count($grid) * 3 / 2 - 1));
    $large += findGardenPlots($grid, count($grid) - 1, count($grid) - 1, (int) (count($grid) * 3 / 2 - 1));
    $large += findGardenPlots($grid, 0, 0, (int) (count($grid) * 3 / 2 - 1));
    $large += findGardenPlots($grid, 0, count($grid) - 1, (int) (count($grid) * 3 / 2 - 1));

    return (
        ($odd * $oddPoints)
        + ($even * $evenPoints)
        + $corners
        + (($gridWidth + 1) * $small)
        + ($gridWidth * $large)
    );
}

check('2023 Day 21 Part 2 Example (6 steps)', ['2023/inputs/day-21/part-2-example.txt', 6], part2(...), 16);
check('2023 Day 21 Part 2 Example (10 steps)', ['2023/inputs/day-21/part-2-example.txt', 10], part2(...), 50);
check('2023 Day 21 Part 2 Example (50 steps)', ['2023/inputs/day-21/part-2-example.txt', 50], part2(...), 1594);
check('2023 Day 21 Part 2 Example (100 steps)', ['2023/inputs/day-21/part-2-example.txt', 100], part2(...), 6536);
check('2023 Day 21 Part 2 Example (500 steps)', ['2023/inputs/day-21/part-2-example.txt', 500], part2(...), 167004);
check('2023 Day 21 Part 2 Example (1000 steps)', ['2023/inputs/day-21/part-2-example.txt', 1000], part2(...), 668697);
check('2023 Day 21 Part 2 Example (5000 steps)', ['2023/inputs/day-21/part-2-example.txt', 5000], part2(...), 16733044);
// produce('2023 Day 21 Part 2', ['2023/inputs/day-21/input.txt', 26501365], part2(...));
