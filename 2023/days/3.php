<?php

namespace AOC2023\Day3;

function part1(string $input): int
{
    $lines = explode(PHP_EOL, $input);
    $total = 0;
    $symbolMap = [];

    foreach ($lines as $lineNumber => $line) {
        if ('' === $line) {
            continue;
        }

        foreach (str_split($line) as $column => $value) {
            $symbolMap[$lineNumber][$column] = ! ('.' === $value || is_numeric($value));
        }
    }

    foreach ($lines as $lineNumber => $line) {
        if ('' === $line) {
            continue;
        }

        $number = null;
        $hasSymbolAdjacent = false;

        foreach (str_split($line) as $column => $value) {
            if (is_numeric($value)) {
                $number .= $value;
                $hasSymbolAdjacent = $hasSymbolAdjacent
                    || ($symbolMap[$lineNumber - 1][$column - 1] ??= false) // SW
                    || ($symbolMap[$lineNumber - 1][$column] ??= false) // S
                    || ($symbolMap[$lineNumber - 1][$column + 1] ??= false) // SE
                    || ($symbolMap[$lineNumber][$column - 1] ??= false) // W
                    // ($symbolMap[$lineNumber    ][$column    ] ??= false)
                    || ($symbolMap[$lineNumber][$column + 1] ??= false) // E
                    || ($symbolMap[$lineNumber + 1][$column - 1] ??= false) // NW
                    || ($symbolMap[$lineNumber + 1][$column] ??= false) // N
                    || ($symbolMap[$lineNumber + 1][$column + 1] ??= false);// NE

                continue;
            }

            if ($hasSymbolAdjacent) {
                $total += (int) $number;
            }

            $number = null;
            $hasSymbolAdjacent = false;
        }
    }

    return $total;
}

check('2023 Day 3 Part 1 Example', '2023/inputs/day-3/part-1-example.txt', part1(...), 4361);
produce('2023 Day 3 Part 1', '2023/inputs/day-3/input.txt', part1(...));

// function part2(string $input): int
// {
//     //
// }

// check('2023 Day 3 Part 2 Example', '2023/inputs/day-3/part-2-example.txt', part2(...), null);
// produce('2023 Day 3 Part 2', '2023/inputs/day-3/input.txt', part2(...));
