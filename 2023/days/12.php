<?php

namespace AOC2023\Day12;

use RedisException;

function countArrangements(string $group, array $numbers): int {
    if ("" === $group) {
        return empty($numbers) ? 1 : 0;
    }

    if (empty($numbers)) {
        return str_contains($group, "#") ? 0 : 1;
    }

    try {
        $redis = redisInstance();
        $key = "{$group} " . implode(",", $numbers);
    } catch (RedisException $e) {
        print 'No Redis instance found. Falling back to recursive solution.' . PHP_EOL;

        $redis = null;
    }

    if (null !== $redis && $redis->exists($key)) {
        return (int) $redis->get($key);
    }

    $result = 0;

    if (in_array($group[0], [
        ".",
        "?"
    ])) {
        $result += countArrangements(substr($group, 1), $numbers);
    }

    if (
        in_array($group[0], [
            "#",
            "?"
        ])
        && $numbers[0] <= strlen($group)
        && ! str_contains(substr($group, 0, $numbers[0]), ".")
        && (
            strlen($group) === $numbers[0]
            || "#" !== $group[$numbers[0]]
        )
    ) {
        $result += countArrangements(
            group: substr($group, $numbers[0] + 1),
            numbers: array_slice($numbers, 1)
        );
    }

    if (null !== $redis) {
        $redis->set($key, $result);
    }

    return $result;
}

function part1(string $input): int
{
    $lines = explode(PHP_EOL, trim($input, PHP_EOL));
    $total = 0;

    foreach ($lines as $line) {
        [
            $group,
            $numbers,
        ] = explode(" ", $line);

        $numbers = array_map(static fn ($number) => (int) $number, explode(",", $numbers));

        $total += countArrangements($group, $numbers);
    }

    return $total;
}

check('2023 Day 12 Part 1 Example', '2023/inputs/day-12/part-1-example.txt', part1(...), 21);
// produce('2023 Day 12 Part 1', '2023/inputs/day-12/input.txt', part1(...));

function part2(string $input): int
{
    $lines = explode(PHP_EOL, trim($input, PHP_EOL));
    $total = 0;

    foreach ($lines as $line) {
        [
            $group,
            $numbers,
        ] = explode(" ", $line);

        $group = str_repeat("{$group}?", 5);
        $group = substr($group, 0, -1);

        $numbers = str_repeat("{$numbers},", 5);
        $numbers = substr($numbers, 0, -1);
        $numbers = array_map(static fn ($number) => (int) $number, explode(",", $numbers));

        $total += countArrangements($group, $numbers);
    }

    return $total;
}

check('2023 Day 12 Part 2 Example', '2023/inputs/day-12/part-2-example.txt', part2(...), 525152);
// produce('2023 Day 12 Part 2', '2023/inputs/day-12/input.txt', part2(...));
