<?php

namespace AOC2015\Day6;

function part1(string $input): int
{
    $grid = array_fill(0, 1000, array_fill(0, 1000, false));
    $instructions = explode("\n", $input);

    foreach ($instructions as $instruction) {
        if ('' === $instruction) {
            continue;
        }

        preg_match('/(turn on|turn off|toggle) (\d+),(\d+) through (\d+),(\d+)/', $instruction, $matches);
        [
            ,
            $action,
            $x1,
            $y1,
            $x2,
            $y2,
        ] = $matches;

        for ($x = $x1; $x <= $x2; $x++) {
            for ($y = $y1; $y <= $y2; $y++) {
                switch ($action) {
                    case 'turn on':
                        $grid[$x][$y] = true;
                        break;
                    case 'turn off':
                        $grid[$x][$y] = false;
                        break;
                    case 'toggle':
                        $grid[$x][$y] = ! $grid[$x][$y];
                        break;
                }
            }
        }
    }

    $litLights = 0;
    foreach ($grid as $row) {
        $litLights += count(array_filter($row));
    }

    return $litLights;
}

check('2015 Day 6 Part 1 Example', '2015/inputs/day-6/part-1-example.txt', part1(...), 998996);
produce('2015 Day 6 Part 1', '2015/inputs/day-6/input.txt', part1(...));

function part2(string $input): int
{
    $grid = array_fill(0, 1000, array_fill(0, 1000, 0));
    $instructions = explode("\n", $input);

    foreach ($instructions as $instruction) {
        if ('' === $instruction) {
            continue;
        }

        preg_match('/(turn on|turn off|toggle) (\d+),(\d+) through (\d+),(\d+)/', $instruction, $matches);
        [
            ,
            $action,
            $x1,
            $y1,
            $x2,
            $y2,
        ] = $matches;

        for ($x = $x1; $x <= $x2; $x++) {
            for ($y = $y1; $y <= $y2; $y++) {
                switch ($action) {
                    case 'turn on':
                        $grid[$x][$y]++;
                        break;
                    case 'turn off':
                        $grid[$x][$y] = max(0, $grid[$x][$y] - 1);
                        break;
                    case 'toggle':
                        $grid[$x][$y] += 2;
                        break;
                }
            }
        }
    }

    $totalBrightness = 0;
    foreach ($grid as $row) {
        $totalBrightness += array_sum($row);
    }

    return $totalBrightness;
}

check('2015 Day 6 Part 2 Example', '2015/inputs/day-6/part-2-example.txt', part2(...), 2000001);
produce('2015 Day 6 Part 2', '2015/inputs/day-6/input.txt', part2(...));
