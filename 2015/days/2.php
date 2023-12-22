<?php

namespace AOC2015\Day2;

function part1(string $input): int
{
    // L*W*H
    // 2*l*w + 2*w*h + 2*h*l + smallest side

    $lines = explode("\n", $input);
    $totalPaper = 0;

    foreach ($lines as $line) {
        if ('' === $line) {
            continue;
        }

        [
            $l,
            $w,
            $h,
        ] = explode('x', $line);

        $sides = [
            $l * $w,
            $w * $h,
            $h * $l,
        ];

        $smallestSide = min($sides);

        $sides = array_map(fn ($side) => $side * 2, $sides);

        $totalPaper += array_sum($sides) + $smallestSide;
    }

    return $totalPaper;
}

check('2015 Day 2 Part 1 Example', '2x3x4', part1(...), 58);
check('2015 Day 2 Part 1 Example', '1x1x10', part1(...), 43);
// produce('2015 Day 2 Part 1', '2015/inputs/day-2/input.txt', part1(...));

function part2(string $input): int
{
    $lines = explode("\n", $input);
    $totalRibbon = 0;

    foreach ($lines as $line) {
        if ('' === $line) {
            continue;
        }

        [
            $l,
            $w,
            $h,
        ] = explode('x', $line);

        $sides = [
            $l,
            $w,
            $h,
        ];

        $largestSide = max($sides);
        $largestSideIndex = array_search($largestSide, $sides);
        unset($sides[$largestSideIndex]);

        $ribbon = array_map(fn ($side) => $side + $side, $sides);
        $bow = $l * $w * $h;

        $totalRibbon += array_sum($ribbon) + $bow;
    }

    return $totalRibbon;
}

check('2015 Day 2 Part 2 Example', '2x3x4', part2(...), 34);
check('2015 Day 2 Part 2 Example', '1x1x10', part2(...), 14);
// produce('2015 Day 2 Part 2', '2015/inputs/day-2/input.txt', part2(...));
