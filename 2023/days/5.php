<?php

namespace AOC2023\Day5;

use Exception;

function part1(string $input): int
{
    $sections = explode(PHP_EOL . PHP_EOL, rtrim($input, PHP_EOL));
    $seeds = explode(' ', str_replace('seeds: ', '', array_shift($sections)));

    $maps = [];

    foreach ($sections as $map) {
        $lines = explode(PHP_EOL, $map);
        $name = array_shift($lines);
        $name = str_replace(' map:', '', $name);
        $src = explode('-to-', $name)[0];
        $maps[$src] = $lines;
    }

    $lowestLocation = PHP_INT_MAX;

    $seed = min($seeds);
    $value = $seed;

    foreach (array_keys($maps) as $src) {
        $value = (function (int $value, array $map): int {
            foreach ($map as $line) {
                [
                    $dstStart,
                    $srcStart,
                    $length,
                ] = explode(' ', $line);

                if ($value >= (int) $srcStart && $value < (int) $srcStart + (int) $length) {
                    return (int) $dstStart + ($value - (int) $srcStart);
                }
            }

            return $value;
        })(
            $value, $maps[$src]);
    }

    return min($lowestLocation, $value);
}

check('2023 Day 5 Part 1 Example', '2023/inputs/day-5/part-1-example.txt', part1(...), 35);
check('2023 Day 5 Part 1', '2023/inputs/day-5/input.txt', part1(...), 111627841);
produce('2023 Day 5 Part 1', '2023/inputs/day-5/input.txt', part1(...));

function part2(string $input): int
{
    $sections = explode(PHP_EOL . PHP_EOL, rtrim($input, PHP_EOL));

    $seedRanges = explode(' ', str_replace('seeds: ', '', array_shift($sections)));
    $seedRanges = array_chunk($seedRanges, 2);
    array_walk($seedRanges, fn (&$range) => $range = [
        (int) $range[0],
        (int) $range[0] + ((int) $range[1] - 1),
    ]);

    $maps = [];

    foreach ($sections as $map) {
        $lines = explode(PHP_EOL, $map);
        $name = array_shift($lines);
        $name = str_replace(' map:', '', $name);
        $src = explode('-to-', $name)[0];
        $maps[$src] = $lines;

        array_walk($maps[$src], function (&$line) {
            [
                $dstStart,
                $srcStart,
                $length,
            ] = explode(' ', $line);

            $line = [
                (int) $dstStart,
                (int) $srcStart,
                (int) $length,
            ];
        });
    }

    foreach ($maps as $map) {
        $newRanges = [];

        foreach ($seedRanges as $seedRange) {
            $resultRanges = [];

            [
                $min,
                $max,
            ] = $seedRange;

            foreach ($map as $mapping) {
                [
                    $dstStart,
                    $srcStart,
                    $length,
                ] = $mapping;

                $srcEnd = $srcStart + ($length - 1);

                if ($min <= $srcEnd && $max >= $srcStart) {
                    $mappedMin = max($min, $srcStart);
                    $mappedMax = min($max, $srcEnd);

                    $resultRanges[] = [
                        $dstStart + ($mappedMin - $srcStart),
                        $dstStart + ($mappedMax - $srcStart),
                    ];
                }
            }

            if (empty($resultRanges)) {
                $resultRanges[] = $seedRange;
            }

            $newRanges = array_merge($newRanges, $resultRanges);
        }

        $seedRanges = $newRanges;
    }

    $lowestLocation = PHP_INT_MAX;

    foreach ($seedRanges as $range) {
        $lowestLocation = min($lowestLocation, $range[0], $range[1]);
    }

    if (PHP_INT_MAX === $lowestLocation) {
        throw new Exception('No solution found');
    }

    return $lowestLocation;
}

check('2023 Day 5 Part 2 Example', '2023/inputs/day-5/part-2-example.txt', part2(...), 46);
check('2023 Day 5 Part 2', '2023/inputs/day-5/input.txt', part2(...), 69323688);
produce('2023 Day 5 Part 2', '2023/inputs/day-5/input.txt', part2(...));
