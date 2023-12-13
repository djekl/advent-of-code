<?php

namespace AOC2023\Day13;

function part1(string $input): int
{
    $groups = array_map(
        callback: static fn ($group) => explode(PHP_EOL, $group),
        array: explode(
            separator: PHP_EOL . PHP_EOL,
            string: trim($input, PHP_EOL),
        ),
    );

    $findReflectionPoint = static function (array $group): int {
        $count = count($group);

        for ($row = 1; $row < $count; $row++) {
            $above = array_reverse(array_slice($group, 0, $row));
            $below = array_slice($group, $row);

            $above = array_slice($above, 0, count($below));
            $below = array_slice($below, 0, count($above));

            if ($above === $below) {
                return $row;
            }
        }

        return 0;
    };

    $total = 0;

    foreach ($groups as $group) {
        $row = $findReflectionPoint($group);
        $total += $row * 100;

        $group = array_map(null, ...array_map('str_split', $group));
        $col = $findReflectionPoint($group);
        $total += $col;
    }

    return $total;
}

check('2023 Day 13 Part 1 Example', '2023/inputs/day-13/part-1-example.txt', part1(...), 405);
produce('2023 Day 13 Part 1', '2023/inputs/day-13/input.txt', part1(...));

function part2(string $input): int
{
    $groups = array_map(
        callback: static fn ($group) => explode(PHP_EOL, $group),
        array: explode(
            separator: PHP_EOL . PHP_EOL,
            string: trim($input, PHP_EOL),
        ),
    );

    $findReflectionPoint = static function (array $group): int {
        $count = count($group);

        for ($row = 1; $row < $count; $row++) {
            $above = array_reverse(array_slice($group, 0, $row));
            $below = array_slice($group, $row);

            $above = array_slice($above, 0, count($below));
            $below = array_slice($below, 0, count($above));

            $diff = 0;

            foreach (array_map(null, $above, $below) as [$x, $y]) {
                $diff += array_sum(
                    array_map(
                        static fn ($a, $b) => $a === $b ? 0 : 1,
                        str_split($x ?? ''),
                        str_split($y ?? ''),
                    )
                );
            }

            if ($diff === 1) {
                return $row;
            }
        }

        return 0;
    };

    $total = 0;

    foreach ($groups as $group) {
        $row = $findReflectionPoint($group);
        $total += $row * 100;

        $group = array_map(null, ...array_map('str_split', $group));
        $col = $findReflectionPoint(array_map(static fn ($row) => implode('', $row), $group));
        $total += $col;
    }

    return $total;
}

check('2023 Day 13 Part 2 Example', '2023/inputs/day-13/part-2-example.txt', part2(...), 400);
produce('2023 Day 13 Part 2', '2023/inputs/day-13/input.txt', part2(...));
