<?php

namespace AOC2024\Day3;

function part1(string $input): int
{
    $pattern = '/mul\((\d{1,3}),(\d{1,3})\)/';
    preg_match_all($pattern, $input, $matches);

    $totalSum = 0;

    foreach ($matches[1] as $index => $x) {
        $y = $matches[2][$index];
        $totalSum += (int) $x * (int) $y;
    }

    return $totalSum;
}

check('2024 Day 3 Part 1 Example', '2024/inputs/day-3/part-1-example.txt', part1(...), 161);
produce('2024 Day 3 Part 1', '2024/inputs/day-3/input.txt', part1(...));

function part2(string $input): int
{
    $mulPattern = '/do\(\)/';
    $dontPattern = '/don\'t\(\)/';

    $totalSum = 0;
    $enabled = true;

    preg_match_all('/(do\(\))|((?:don\'t\()\)|mul\([0-9]+,[0-9]+\))/', $input, $matches);

    foreach ($matches[0] as $instruction) {
        if (preg_match($mulPattern, $instruction)) {
            $enabled = true;
        } elseif (preg_match($dontPattern, $instruction)) {
            $enabled = false;
        } elseif ($enabled) {
            preg_match('/mul\(([0-9]+),([0-9]+)\)/', $instruction, $mulMatches);

            if (isset($mulMatches[1], $mulMatches[2])) {
                $x = (int) $mulMatches[1];
                $y = (int) $mulMatches[2];
                $totalSum += $x * $y;
            }
        }
    }

    return $totalSum;
}

check('2024 Day 3 Part 2 Example', '2024/inputs/day-3/part-2-example.txt', part2(...), 48);
produce('2024 Day 3 Part 2', '2024/inputs/day-3/input.txt', part2(...));
