<?php

namespace AOC2015\Day9;

function calculatePossibleRoutes(array $items): array
{
    if (count($items) === 1) {
        return [$items];
    }

    $perms = [];

    foreach ($items as $i => $item) {
        $rest = $items;
        unset($rest[$i]);

        foreach (calculatePossibleRoutes($rest) as $perm) {
            $perms[] = array_merge([$item], $perm);
        }
    }

    return $perms;
}

function part1(string $input): int
{
    $distances = [];
    $locations = [];

    foreach (explode(PHP_EOL, $input) as $line) {
        if ('' === $line) {
            continue;
        }

        [
            $from,
            $to,
            $distance,
        ] = sscanf($line, "%s to %s = %d");

        $distances[$from][$to] = $distance;
        $distances[$to][$from] = $distance;

        $locations[] = $from;
        $locations[] = $to;
    }

    $locations = array_unique($locations);
    $routes = calculatePossibleRoutes($locations);
    $shortestDistance = PHP_INT_MAX;

    foreach ($routes as $route) {
        $distance = 0;

        for ($i = 0; $i < count($route) - 1; $i++) {
            $distance += $distances[$route[$i]][$route[$i + 1]];
        }

        $shortestDistance = min($shortestDistance, $distance);
    }

    return $shortestDistance;
}

check('2015 Day 9 Part 1 Example', '2015/inputs/day-9/part-1-example.txt', part1(...), 605);
produce('2015 Day 9 Part 1', '2015/inputs/day-9/input.txt', part1(...));

function part2(string $input): int
{
    $distances = [];
    $locations = [];

    foreach (explode(PHP_EOL, $input) as $line) {
        if ('' === $line) {
            continue;
        }

        [
            $from,
            $to,
            $distance,
        ] = sscanf($line, "%s to %s = %d");

        $distances[$from][$to] = $distance;
        $distances[$to][$from] = $distance;

        $locations[] = $from;
        $locations[] = $to;
    }

    $locations = array_unique($locations);
    $routes = calculatePossibleRoutes($locations);
    $longestDistance = 0;

    foreach ($routes as $route) {
        $distance = 0;

        for ($i = 0; $i < count($route) - 1; $i++) {
            $distance += $distances[$route[$i]][$route[$i + 1]];
        }

        $longestDistance = max($longestDistance, $distance);
    }

    return $longestDistance;
}

check('2015 Day 9 Part 2 Example', '2015/inputs/day-9/part-2-example.txt', part2(...), 982);
produce('2015 Day 9 Part 2', '2015/inputs/day-9/input.txt', part2(...));
