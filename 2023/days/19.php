<?php

namespace AOC2023\Day19;

function accepted(array $workflows, array $message, string $name = 'in'): bool {
    if (in_array($name, ['A', 'R'])) {
        return $name === 'A';
    }

    [$rules, $fallback] = array_values($workflows[$name]);

    foreach ($rules as $rule) {
        $key = $rule['key'];

        $valid = match($rule['operation']) {
            '>' => $message[$key] > $rule['number'],
            '<' => $message[$key] < $rule['number'],
        };

        if ($valid) {
            return accepted($workflows, $message, $rule['target']);
        }
    }

    return accepted($workflows, $message, $fallback);
}

function part1(string $input): int
{
    [$block1, $block2] = explode("\n\n", rtrim($input, PHP_EOL));

    $workflows = [];

    foreach (explode("\n", trim($block1)) as $line) {
        [$name, $ruleString] = explode("{", rtrim($line, "}"));

        $rules = explode(",", $ruleString);
        $fallback = array_pop($rules);
        $workflowRules = [];

        foreach ($rules as $rule) {
            [$ruleString, $target] = explode(":", $rule);

            $workflowRules[] = [
                'key' => $ruleString[0],
                'operation' => $ruleString[1],
                'number' => (int) substr($ruleString, 2),
                'target' => $target,
            ];
        }

        $workflows[$name] = [$workflowRules, $fallback];
    }

    $total = 0;

    foreach (explode("\n", trim($block2)) as $line) {
        $item = [];

        foreach (explode(",", trim($line, "{}")) as $segment) {
            [$key, $value] = explode("=", $segment);

            $item[$key] = $value;
        }

        if (accepted($workflows, $item)) {
            $total += array_sum($item);
        }
    }

    return $total;
}

check('2023 Day 19 Part 1 Example', '2023/inputs/day-19/part-1-example.txt', part1(...), 19114);
check('2023 Day 19 Part 1 Example', '2023/inputs/day-19/input.txt', part1(...), 376008);
// produce('2023 Day 19 Part 1', '2023/inputs/day-19/input.txt', part1(...));

function totalCount(array $workflows, $ranges, $name = "in") {
    if ('R' === $name) {
        return 0;
    }

    if ('A' === $name) {
        $product = 1;

        foreach ($ranges as $range) {
            [$low, $high] = $range;
            $product *= $high - $low + 1;
        }

        return $product;
    }

    [$rules, $fallback] = $workflows[$name];

    $total = 0;

    foreach ($rules as $rule) {
        [$low, $high] = $ranges[$rule['key']];

        if ('<' === $rule['operation']) {
            $valid = [$low, $rule['number'] - 1];
            $invalid = [$rule['number'], $high];
        } else {
            $valid = [$rule['number'] + 1, $high];
            $invalid = [$low, $rule['number']];
        }

        if ($valid[0] <= $valid[1]) {
            $copy = $ranges;
            $copy[$rule['key']] = $valid;

            $total += totalCount($workflows, $copy, $rule['target']);
        }

        if ($invalid[0] <= $invalid[1]) {
            $ranges[$rule['key']] = $invalid;
        }
    }

    return $total + totalCount($workflows, $ranges, $fallback);
}

function part2(string $input): int
{
    [$block1,] = explode("\n\n", rtrim($input, PHP_EOL));

    $workflows = [];

    foreach (explode("\n", trim($block1)) as $line) {
        [$name, $ruleString] = explode("{", rtrim($line, "}"));

        $rules = explode(",", $ruleString);
        $fallback = array_pop($rules);
        $workflowRules = [];

        foreach ($rules as $rule) {
            [$ruleString, $target] = explode(":", $rule);

            $workflowRules[] = [
                'key' => $ruleString[0],
                'operation' => $ruleString[1],
                'number' => (int) substr($ruleString, 2),
                'target' => $target,
            ];
        }

        $workflows[$name] = [$workflowRules, $fallback];
    }

    $ranges = [];

    foreach (str_split("xmas") as $key) {
        $ranges[$key] = [1, 4000];
    }

    return totalCount($workflows, $ranges);
}

check('2023 Day 19 Part 2 Example', '2023/inputs/day-19/part-2-example.txt', part2(...), 167409079868000);
check('2023 Day 19 Part 2 Example', '2023/inputs/day-19/input.txt', part2(...), 124078207789312);
// produce('2023 Day 19 Part 2', '2023/inputs/day-19/input.txt', part2(...));
