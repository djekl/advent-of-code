<?php

namespace AOC2015\Day7;

function getSignal($wire, &$circuit, &$signals): int
{
    if (isset($signals[$wire])) {
        return $signals[$wire];
    }

    if (is_numeric($wire)) {
        return $wire;
    }

    $parts = $circuit[$wire];

    if (count($parts) === 1) {
        $res = getSignal($parts[0], $circuit, $signals);
    } elseif ($parts[1] === 'AND') {
        $res = getSignal($parts[0], $circuit, $signals) & getSignal($parts[2], $circuit, $signals);
    } elseif ($parts[1] === 'OR') {
        $res = getSignal($parts[0], $circuit, $signals) | getSignal($parts[2], $circuit, $signals);
    } elseif ($parts[1] === 'LSHIFT') {
        $res = getSignal($parts[0], $circuit, $signals) << $parts[2];
    } elseif ($parts[1] === 'RSHIFT') {
        $res = getSignal($parts[0], $circuit, $signals) >> $parts[2];
    } elseif ($parts[0] === 'NOT') {
        $res = ~getSignal($parts[1], $circuit, $signals);
    }

    $signals[$wire] = $res;

    return $res;
}


function part1(string $input): int
{
    $circuit = [];
    $signals = [];

    foreach (explode(PHP_EOL, $input) as $line) {
        if ('' === $line) {
            continue;
        }

        [
            $instr,
            $wire,
        ] = explode(' -> ', $line);

        $circuit[$wire] = explode(' ', $instr);
    }

    return getSignal('a', $circuit, $signals);
}

check('2015 Day 7 Part 1 Example', '2015/inputs/day-7/input.txt', part1(...), 3176);
// produce('2015 Day 7 Part 1', '2015/inputs/day-7/input.txt', part1(...));

function part2(string $input): int
{
    $circuit = [];
    $signals = [];

    foreach (explode(PHP_EOL, $input) as $line) {
        if ('' === $line) {
            continue;
        }

        [
            $instr,
            $wire,
        ] = explode(' -> ', $line);

        $circuit[$wire] = explode(' ', $instr);
    }

    $aSignal = getSignal('a', $circuit, $signals);

    // Reset the signals and override the signal of wire 'b'
    $signals = [];
    $signals['b'] = $aSignal;

    return getSignal('a', $circuit, $signals);
}

check('2015 Day 7 Part 2', '2015/inputs/day-7/input.txt', part2(...), 14710);
// produce('2015 Day 7 Part 2', '2015/inputs/day-7/input.txt', part2(...));
