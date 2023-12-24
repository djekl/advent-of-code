<?php

namespace AOC2023\Day24;

function part1(string $input, int $min, int $max): int
{
    $lines = explode(PHP_EOL, trim($input, PHP_EOL));
    $hailstones = [];

    foreach ($lines as $line) {
        [$px, $py, $pz, $vx, $vy, $vz] = sscanf($line, '%d, %d, %d @ %d, %d, %d');
        $hailstones[] = (object) [
            'px' => $px,
            'py' => $py,
            'pz' => $pz,
            'vx' => $vx,
            'vy' => $vy,
            'vz' => $vz,

            'a' => $vy,
            'b' => -$vx,
            'c' => $vy * $px - $vx * $py,
        ];
    }

    $total = 0;

    foreach ($hailstones as $i => $hs1) {
        foreach ($hailstones as $j => $hs2) {
            if ($j >= $i) {
                continue;
            }

            if ($hs1->a * $hs2->b === $hs1->b * $hs2->a) {
                continue;
            }

            $x = ($hs1->c * $hs2->b - $hs2->c * $hs1->b) / ($hs1->a * $hs2->b - $hs2->a * $hs1->b);
            $y = ($hs2->c * $hs1->a - $hs1->c * $hs2->a) / ($hs1->a * $hs2->b - $hs2->a * $hs1->b);


            $positionCheck = (
                $x >= $min
                && $x <= $max
                && $y >= $min
                && $y <= $max
            );

            if (
                $positionCheck
                && ($x - $hs1->px) * $hs1->vx >= 0
                && ($y - $hs1->py) * $hs1->vy >= 0
                && ($x - $hs2->px) * $hs2->vx >= 0
                && ($y - $hs2->py) * $hs2->vy >= 0
            ) {
                $total++;
            }
        }
    }

    return $total;
}

check('2023 Day 24 Part 1 Example', ['2023/inputs/day-24/part-1-example.txt', 7, 27], part1(...), 2);
// produce('2023 Day 24 Part 1', ['2023/inputs/day-24/input.txt', 200000000000000, 400000000000000], part1(...));

function part2(string $input): int
{
    //
}
// check('2023 Day 24 Part 2 Example', '2023/inputs/day-24/part-2-example.txt', part2(...), null);
// produce('2023 Day 24 Part 2', '2023/inputs/day-24/input.txt', part2(...));
