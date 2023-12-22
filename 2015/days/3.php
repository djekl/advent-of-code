<?php

namespace AOC2015\Day3;

function part1(string $input): int
{
    $input = trim($input, PHP_EOL);

    $houses = ['0,0' => 1];
    $x = $y = 0;

    for ($i = 0; $i < strlen($input); $i++) {
        switch ($input[$i]) {
            case '^':
                $y++;
                break;
            case 'v':
                $y--;
                break;
            case '>':
                $x++;
                break;
            case '<':
                $x--;
                break;
        }

        $key = "$x,$y";

        if (! isset($houses[$key])) {
            $houses[$key] = 0;
        }

        $houses[$key]++;
    }

    return count($houses);
}

check('2015 Day 3 Part 1 Example', '>', part1(...), 2);
check('2015 Day 3 Part 1 Example', '^>v<', part1(...), 4);
check('2015 Day 3 Part 1 Example', '^v^v^v^v^v', part1(...), 2);
// produce('2015 Day 3 Part 1', '2015/inputs/day-3/input.txt', part1(...));

function part2(string $input): int
{
    $input = trim($input, PHP_EOL);

    $housesSanta = ['0,0' => 1];
    $housesRoboSanta = ['0,0' => 1];
    $xSanta = $ySanta = $xRoboSanta = $yRoboSanta = 0;

    for ($i = 0; $i < strlen($input); $i++) {
        $moveSanta = $i % 2 === 0;
        $x = $moveSanta ? $xSanta : $xRoboSanta;
        $y = $moveSanta ? $ySanta : $yRoboSanta;

        switch ($input[$i]) {
            case '^':
                $y++;
                break;
            case 'v':
                $y--;
                break;
            case '>':
                $x++;
                break;
            case '<':
                $x--;
                break;
        }

        $key = "$x,$y";
        if ($moveSanta) {
            $xSanta = $x;
            $ySanta = $y;

            if (! isset($housesSanta[$key])) {
                $housesSanta[$key] = 0;
            }

            $housesSanta[$key]++;
        } else {
            $xRoboSanta = $x;
            $yRoboSanta = $y;

            if (! isset($housesRoboSanta[$key])) {
                $housesRoboSanta[$key] = 0;
            }

            $housesRoboSanta[$key]++;
        }
    }

    $houses = $housesSanta + $housesRoboSanta;

    return count($houses);
}

check('2015 Day 3 Part 2 Example', '^v', part2(...), 3);
check('2015 Day 3 Part 2 Example', '^>v<', part2(...), 3);
check('2015 Day 3 Part 2 Example', '^v^v^v^v^v', part2(...), 11);
// produce('2015 Day 3 Part 2', '2015/inputs/day-3/input.txt', part2(...));
