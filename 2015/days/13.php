<?php

namespace AOC2015\Day13;

function possibilities(array $items): array
{
    if (count($items) === 1) {
        return [$items];
    }

    $perms = [];

    foreach ($items as $i => $item) {
        $rest = $items;
        unset($rest[$i]);

        foreach (possibilities($rest) as $perm) {
            $perms[] = array_merge([$item], $perm);
        }
    }

    return $perms;
}

function part1(string $input): int
{
    $happiness = [];
    $people = [];

    foreach (explode(PHP_EOL, $input) as $line) {
        if ('' === $line) {
            continue;
        }

        preg_match('/(\w+) would (gain|lose) (\d+) happiness units by sitting next to (\w+)\./', $line, $matches);
        [
            ,
            $person1,
            $gainOrLose,
            $units,
            $person2,
        ] = $matches;
        $units = $gainOrLose === 'lose' ? -$units : $units;
        $happiness[$person1][$person2] = $units;
        $people[] = $person1;
    }

    $people = array_unique($people);
    $arrangements = possibilities($people);
    $maxHappiness = PHP_INT_MIN;

    foreach ($arrangements as $arrangement) {
        $total = 0;

        foreach ($arrangement as $i => $iValue) {
            $neighbor1 = $arrangement[($i - 1 + count($arrangement)) % count($arrangement)];
            $neighbor2 = $arrangement[($i + 1) % count($arrangement)];
            $total += $happiness[$iValue][$neighbor1] + $happiness[$iValue][$neighbor2];
        }

        $maxHappiness = max($maxHappiness, $total);
    }

    return $maxHappiness;
}

check('2015 Day 13 Part 1 Example', '2015/inputs/day-13/part-1-example.txt', part1(...), 330);
produce('2015 Day 13 Part 1', '2015/inputs/day-13/input.txt', part1(...));

function part2(string $input): int
{
    $happiness = [];
    $people = [];

    foreach (explode(PHP_EOL, $input) as $line) {
        if ('' === $line) {
            continue;
        }

        preg_match('/(\w+) would (gain|lose) (\d+) happiness units by sitting next to (\w+)\./', $line, $matches);
        [
            ,
            $person1,
            $gainOrLose,
            $units,
            $person2,
        ] = $matches;
        $units = $gainOrLose === 'lose' ? -$units : $units;
        $happiness[$person1][$person2] = $units;
        $people[] = $person1;
    }

    $people[] = 'You';
    foreach ($people as $person) {
        $happiness['You'][$person] = 0;
        $happiness[$person]['You'] = 0;
    }

    $people = array_unique($people);
    $arrangements = possibilities($people);
    $maxHappiness = PHP_INT_MIN;

    foreach ($arrangements as $arrangement) {
        $total = 0;

        foreach ($arrangement as $i => $iValue) {
            $neighbor1 = $arrangement[($i - 1 + count($arrangement)) % count($arrangement)];
            $neighbor2 = $arrangement[($i + 1) % count($arrangement)];
            $total += $happiness[$iValue][$neighbor1] + $happiness[$iValue][$neighbor2];
        }

        $maxHappiness = max($maxHappiness, $total);
    }

    return $maxHappiness;
}

produce('2015 Day 13 Part 2', '2015/inputs/day-13/input.txt', part2(...));
