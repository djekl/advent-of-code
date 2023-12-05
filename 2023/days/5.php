<?php

namespace AOC2023\Day5;

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

    $minLocation = PHP_INT_MAX;

    foreach ($seeds as $seed) {
        $value = $seed;
        foreach (array_keys($maps) as $src) {
            $value = (function (int $value, array $map): int {
                foreach ($map as $line) {
                    [
                        $destStart,
                        $srcStart,
                        $length,
                    ] = explode(' ', $line);

                    if ($value >= (int) $srcStart && $value < (int) $srcStart + (int) $length) {
                        return (int) $destStart + ($value - (int) $srcStart);
                    }
                }

                return $value;
            })(
                $value, $maps[$src]);
        }

        $minLocation = min($minLocation, $value);
    }

    return $minLocation;
}

check('2023 Day 5 Part 1 Example', '2023/inputs/day-5/part-1-example.txt', part1(...), 35);
produce('2023 Day 5 Part 1', '2023/inputs/day-5/input.txt', part1(...));

function part2(string $input): int
{
    $sections = explode(PHP_EOL . PHP_EOL, rtrim($input, PHP_EOL));
    $seedRanges = explode(' ', str_replace('seeds: ', '', array_shift($sections)));
    $maps = [];

    foreach ($sections as $map) {
        $lines = explode(PHP_EOL, $map);
        $name = array_shift($lines);
        $name = str_replace(' map:', '', $name);
        $src = explode('-to-', $name)[0];
        $maps[$src] = $lines;
    }

    $minLocation = PHP_INT_MAX;

    for ($i = 0, $iMax = count($seedRanges); $i < $iMax; $i += 2) {
        $start = $seedRanges[$i];
        $length = $seedRanges[$i + 1];

        for ($j = 0; $j < $length; $j++) {
            $seed = $start + $j;
            $value = $seed;

            foreach (array_keys($maps) as $src) {
                $value = (function (int $value, array $map): int {
                    foreach ($map as $line) {
                        [
                            $destStart,
                            $srcStart,
                            $length,
                        ] = explode(' ', $line);

                        if ($value >= (int) $srcStart && $value < (int) $srcStart + (int) $length) {
                            return (int) $destStart + ($value - $srcStart);
                        }
                    }

                    return $value;
                })(
                    $value, $maps[$src]);
            }

            $minLocation = min($minLocation, $value);
        }
    }

    return $minLocation;
}

check('2023 Day 5 Part 2 Example', '2023/inputs/day-5/part-2-example.txt', part2(...), 46);
produce('2023 Day 5 Part 2', '2023/inputs/day-5/input.txt', part2(...));
