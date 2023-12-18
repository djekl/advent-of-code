<?php

namespace AOC2023\Day18;

function part1(string $input): int
{
    $instructions = explode(PHP_EOL, trim($input, PHP_EOL));
    $points = [[0, 0]];
    $boundary = 0;

    foreach ($instructions as $line) {
        [$direction, $distance] = explode(' ', $line);

        $boundary += $distance = (int) $distance;
        $direction = match ($direction) {
            'U' => [-1, 0],
            'R' => [0, 1],
            'D' => [1, 0],
            'L' => [0, -1],
        };

        $position = end($points);
        $position[0] += $direction[0] * $distance;
        $position[1] += $direction[1] * $distance;
        $points[] = $position;
    }

    $area = abs(array_sum(array_map(function ($i) use ($points) {
        $length = count($points);

        $currentPoint = $points[$i][0];
        $previousPoint = $points[($i > 0 ? $i - 1 : $i)][1];
        $nextPoint = $points[($i < $length - 1 ? $i + 1 : $i)][1];

        return $currentPoint * ($previousPoint - $nextPoint);
    }, array_keys($points)))) / 2;

    return ($area - $boundary / 2 + 1) + $boundary;
}

check('2023 Day 18 Part 1 Example', '2023/inputs/day-18/part-1-example.txt', part1(...), 62);
produce('2023 Day 18 Part 1', '2023/inputs/day-18/input.txt', part1(...));

function part2(string $input): int
{
    $instructions = explode(PHP_EOL, trim($input, PHP_EOL));
    $points = [[0, 0]];
    $boundary = 0;

    foreach ($instructions as $line) {
        preg_match('/^[^#\\(]+\\(#([^\\)]+)\\)$/u', $line, $matches);
        $inputValue = $matches[1];

        $direction = substr($inputValue, -1);
        $distance = hexdec(substr($inputValue, 0, -1));

        $boundary += $distance;
        $direction = match ($direction) {
            '0' => [0, 1],
            '1' => [1, 0],
            '2' => [0, -1],
            '3' => [-1, 0],
        };

        $position = end($points);
        $position[0] += $direction[0] * $distance;
        $position[1] += $direction[1] * $distance;
        $points[] = $position;
    }

    $area = abs(array_sum(array_map(function ($i) use ($points) {
            $length = count($points);

            $currentPoint = $points[$i][0];
            $previousPoint = $points[($i > 0 ? $i - 1 : $i)][1];
            $nextPoint = $points[($i < $length - 1 ? $i + 1 : $i)][1];

            return $currentPoint * ($previousPoint - $nextPoint);
        }, array_keys($points)))) / 2;

    return ($area - $boundary / 2 + 1) + $boundary;
}

check('2023 Day 18 Part 2 Example', '2023/inputs/day-18/part-2-example.txt', part2(...), 952408144115);
produce('2023 Day 18 Part 2', '2023/inputs/day-18/input.txt', part2(...));
