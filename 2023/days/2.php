<?php

namespace AOC2023\Day2;

function part1(string $input): int
{
    $known = [
        'red' => 12,
        'green' => 13,
        'blue' => 14,
    ];

    $lines = explode(PHP_EOL, $input);
    $total = 0;

    foreach ($lines as $line) {
        if ('' === $line) {
            continue;
        }

        $validGame = true;

        [
            $game,
            $sets,
        ] = explode(': ', $line);

        foreach (explode('; ', $sets) as $set) {
            foreach (explode(', ', $set) as $shown) {
                [
                    $count,
                    $color,
                ] = explode(' ', $shown);

                if ($count > $known[$color]) {
                    $validGame = false;
                    break;
                }
            }

            if (! $validGame) {
                break;
            }
        }

        if (! $validGame) {
            continue;
        }

        $total += (int) str_replace('Game ', '', $game);
    }

    return $total;
}

check('2023 Day 2 Part 1 Example', '2023/inputs/day-2/part-1-example.txt', part1(...), 8);
// produce('2023 Day 2 Part 1', '2023/inputs/day-2/input.txt', part1(...));

function part2(string $input): int
{
    $lines = explode(PHP_EOL, $input);
    $total = 0;

    foreach ($lines as $line) {
        if ('' === $line) {
            continue;
        }

        $minimum = [
            'red' => 0,
            'green' => 0,
            'blue' => 0,
        ];

        $game = explode(': ', $line);
        $sets = explode('; ', $game[1]);

        foreach ($sets as $set) {
            foreach (explode(', ', $set) as $shown) {
                [
                    $count,
                    $color,
                ] = explode(' ', $shown);

                if ((int) $count > $minimum[$color]) {
                    $minimum[$color] = (int) $count;
                }
            }
        }

        $total += $minimum['red'] * $minimum['green'] * $minimum['blue'];
    }

    return $total;
}

check('2023 Day 2 Part 2 Example', '2023/inputs/day-2/part-2-example.txt', part2(...), 2286);
// produce('2023 Day 2 Part 2', '2023/inputs/day-2/input.txt', part2(...));
