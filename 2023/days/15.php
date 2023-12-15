<?php

namespace AOC2023\Day15;

function part1(string $input): int
{
    $hashes = array_map(static function ($text) {
        $hash = 0;

        foreach (str_split($text) as $char) {
            $hash += ord($char);
            $hash *= 17;
            $hash %= 256;
        }

        return $hash;
    }, explode(',', trim($input, PHP_EOL)));

    return array_sum($hashes);
}

check('2023 Day 15 Part 1 Example', '2023/inputs/day-15/part-1-example.txt', part1(...), 1320);
produce('2023 Day 15 Part 1', '2023/inputs/day-15/input.txt', part1(...));

function part2(string $input): int
{
    $hash = part1(...);
    $instructions = explode(',', trim($input, PHP_EOL));
    $hashMap = array_map(static function () {
        return [];
    }, range(0, 255));
    $focalLengths = [];

    foreach ($instructions as $instruction) {
        if (str_contains($instruction, '-')) {
            $label = substr($instruction, 0, -1);
            $index = $hash($label);

            if (array_key_exists($label, $hashMap[$index])) {
                unset($hashMap[$index][$label]);
            }

            continue;
        }

        [
            $label,
            $length,
        ] = explode('=', $instruction);
        $index = $hash($label);
        $hashMap[$index][$label] = (int) $length;
        $focalLengths[$label] = (int) $length;
    }

    $total = 0;

    foreach ($hashMap as $boxNumber => $box) {
        foreach ($box as $label => $lensSlot) {
            $slot = array_flip(array_keys($box))[$label];
            $total += ($boxNumber + 1) * ($slot + 1) * $focalLengths[$label];
        }
    }

    return $total;
}

check('2023 Day 15 Part 2 Example', '2023/inputs/day-15/part-2-example.txt', part2(...), 145);
produce('2023 Day 15 Part 2', '2023/inputs/day-15/input.txt', part2(...));
