<?php

namespace AOC2015\Day11;

function hasStraight(array $password): bool
{
    for ($i = 0; $i < count($password) - 2; $i++) {
        if (
            ord($password[$i]) + 1 === ord($password[$i + 1])
            && ord($password[$i]) + 2 === ord($password[$i + 2])
        ) {
            return true;
        }
    }

    return false;
}

function hasTwoPairs(array $password): bool
{
    $pairs = 0;

    for ($i = 0; $i < count($password) - 1; $i++) {
        if ($password[$i] === $password[$i + 1]) {
            $pairs++;
            $i++;
        }
    }

    return $pairs >= 2;
}

function part1(string $input): string
{
    $password = str_split(trim($input, PHP_EOL));

    while (
        trim($input, PHP_EOL) === implode('', $password)
        || ! hasStraight($password)
        || ! hasTwoPairs($password)
    ) {
        $i = count($password) - 1;

        while ($i >= 0) {
            if ($password[$i] === 'z') {
                $password[$i] = 'a';
                $i--;
            } else {
                $password[$i]++;

                if (in_array($password[$i], [
                    'i',
                    'o',
                    'l',
                ])) {
                    $password[$i]++;
                }

                break;
            }
        }
    }

    return implode('', $password);
}

check('2015 Day 11 Part 1 Example', '2015/inputs/day-11/input.txt', part1(...), 'hepxxyzz');
// produce('2015 Day 11 Part 1', '2015/inputs/day-11/input.txt', part1(...));

function part2(string $input): string
{
    return part1(part1($input));
}

check('2015 Day 11 Part 2 Example', '2015/inputs/day-11/input.txt', part2(...), 'heqaabcc');
// produce('2015 Day 11 Part 2', '2015/inputs/day-11/input.txt', part2(...));
