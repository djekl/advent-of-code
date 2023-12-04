<?php

namespace AOC2023\Day4;

function part1(string $input): int
{
    $lines = explode(PHP_EOL, $input);
    $total = 0;

    foreach ($lines as $line) {
        if ('' === $line) {
            continue;
        }

        $line = preg_replace('/  /u', ' ', $line);

        [
            $name,
            $game,
        ] = explode(': ', $line);
        [
            $winningNumbers,
            $myNumbers,
        ] = explode(' | ', $game);

        $winningNumbers = explode(' ', trim($winningNumbers));
        $myNumbers = explode(' ', trim($myNumbers));
        $myWinners = array_intersect($winningNumbers, $myNumbers);
        $gameTotal = 0;

        for ($i = 0; $i < count($myWinners); $i++) {
            if ($gameTotal === 0) {
                $gameTotal = 1;

                continue;
            }

            $gameTotal *= 2;
        }

        $total += $gameTotal;
    }

    return $total;
}

check('2023 Day 4 Part 1 Example', '2023/inputs/day-4/part-1-example.txt', part1(...), 13);
produce('2023 Day 4 Part 1', '2023/inputs/day-4/input.txt', part1(...));

function part2(string $input): int
{
    $lines = explode(PHP_EOL, $input);
    $games = [];

    foreach ($lines as $line) {
        if ('' === $line) {
            continue;
        }

        $line = preg_replace('/  /u', ' ', $line);

        [
            $name,
            $game,
        ] = explode(': ', $line);
        [
            $winningNumbers,
            $myNumbers,
        ] = explode(' | ', $game);

        $winningNumbers = explode(' ', trim($winningNumbers));
        $myNumbers = explode(' ', trim($myNumbers));
        $games[$name] = count(array_intersect($winningNumbers, $myNumbers));
    }

    $instances = array_fill_keys(array_keys($games), 1);
    $names = array_keys($games);

    foreach ($names as $gameNumber => $name) {
        $copies = $games[$name];

        for (
            $copyNumber = $gameNumber + 1;
            $copyNumber <= $gameNumber + $copies && $copyNumber < count($names);
            $copyNumber++
        ) {
            $instances[$names[$copyNumber]] += $instances[$name];
        }
    }

    return array_sum($instances);
}

check('2023 Day 4 Part 2 Example', '2023/inputs/day-4/part-2-example.txt', part2(...), 30);
produce('2023 Day 4 Part 2', '2023/inputs/day-4/input.txt', part2(...));
