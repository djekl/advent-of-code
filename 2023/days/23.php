<?php

namespace AOC2023\Day23;

function depthFirstSearch($grid, $visited, $start, $end, $steps, $maxSteps = 0, $part2 = false): int
{
    if ($start === [$end[0], $end[1]]) {
        return max($maxSteps, $steps);
    }

    [$x, $y] = $start;

    foreach ([
        '^' => [-1, 0],
        '>' => [0, 1],
        'v' => [1, 0],
        '<' => [0, -1],
    ] as $dir => [$dx, $dy]) {
        $nx = $x + $dx;
        $ny = $y + $dy;

        if (
            isset($grid[$nx][$ny])
            && ! $visited[$nx][$ny]
            && (
                $part2
                    ? $grid[$nx][$ny] != '#'
                    : in_array($grid[$x][$y], ['.', $dir], true)
            )
        ) {
            $visited[$nx][$ny] = true;

            $maxSteps = depthFirstSearch(
                grid: $grid,
                visited: $visited,
                start: [$nx, $ny],
                end: $end,
                steps: $steps + 1,
                maxSteps: $maxSteps,
                part2: $part2
            );

            $visited[$nx][$ny] = false;
        }
    }

    return $maxSteps;
}

function part1(string $input): int
{
    $grid = explode(PHP_EOL, trim($input, PHP_EOL));
    $visited = array_fill(0, count($grid), array_fill(0, strlen($grid[0]), false));

    $start = [0, strpos($grid[0], '.')];
    $end = [count($grid) - 1, strpos($grid[count($grid) - 1], '.')];
    $visited[$start[0]][$start[1]] = true;

    return depthFirstSearch(
        grid: array_map('str_split', $grid),
        visited: $visited,
        start: $start,
        end: $end,
        steps: 0
    );
}

check('2023 Day 23 Part 1 Example', '2023/inputs/day-23/part-1-example.txt', part1(...), 94);
// produce('2023 Day 23 Part 1', '2023/inputs/day-23/input.txt', part1(...));

function part2(string $input): int
{
    $grid = explode(PHP_EOL, trim($input, PHP_EOL));
    $visited = array_fill(0, count($grid), array_fill(0, strlen($grid[0]), false));

    $start = [0, strpos($grid[0], '.')];
    $end = [count($grid) - 1, strpos($grid[count($grid) - 1], '.')];
    $visited[$start[0]][$start[1]] = true;

    return depthFirstSearch(
        grid: array_map('str_split', $grid),
        visited: $visited,
        start: $start,
        end: $end,
        steps: 0,
        part2: true
    );
}

check('2023 Day 23 Part 2 Example', '2023/inputs/day-23/part-2-example.txt', part2(...), 154);
// produce('2023 Day 23 Part 2', '2023/inputs/day-23/input.txt', part2(...));
