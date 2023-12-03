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
            $symbolMap[$lineNumber][$column] = ('.' !== $value && ! is_numeric($value));
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
                $hasSymbolAdjacent = (
                    $hasSymbolAdjacent
                    || ($symbolMap[$lineNumber - 1][$column - 1] ??= false)
                    || ($symbolMap[$lineNumber - 1][$column] ??= false)
                    || ($symbolMap[$lineNumber - 1][$column + 1] ??= false)
                    || ($symbolMap[$lineNumber][$column - 1] ??= false)
                    // ($symbolMap[$lineNumber][$column] ??= false)
                    || ($symbolMap[$lineNumber][$column + 1] ??= false)
                    || ($symbolMap[$lineNumber + 1][$column - 1] ??= false)
                    || ($symbolMap[$lineNumber + 1][$column] ??= false)
                    || ($symbolMap[$lineNumber + 1][$column + 1] ??= false)
                );

                if ($column === strlen($line) - 1) {
                    if ($hasSymbolAdjacent) {
                        $total += (int) $number;
                    }

                    $number = null;
                    $hasSymbolAdjacent = false;
                }

                continue;
            }

            if (null === $number) {
                $number = null;
                $hasSymbolAdjacent = false;
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

function part2(string $input): int
{
    $lines = explode(PHP_EOL, $input);
    $total = 0;
    $symbolMap = [];
    $partMap = [];

    foreach ($lines as $lineNumber => $line) {
        if ('' === $line) {
            continue;
        }

        foreach (str_split($line) as $column => $value) {
            $symbolMap[$lineNumber][$column] = ('.' !== $value && ! is_numeric($value));
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
                $hasSymbolAdjacent = (
                    $hasSymbolAdjacent
                    || ($symbolMap[$lineNumber - 1][$column - 1] ??= false)
                    || ($symbolMap[$lineNumber - 1][$column] ??= false)
                    || ($symbolMap[$lineNumber - 1][$column + 1] ??= false)
                    || ($symbolMap[$lineNumber][$column - 1] ??= false)
                    // ($symbolMap[$lineNumber][$column] ??= false)
                    || ($symbolMap[$lineNumber][$column + 1] ??= false)
                    || ($symbolMap[$lineNumber + 1][$column - 1] ??= false)
                    || ($symbolMap[$lineNumber + 1][$column] ??= false)
                    || ($symbolMap[$lineNumber + 1][$column + 1] ??= false)
                );

                if ($column !== strlen($line) - 1) {
                    continue;
                }
            }
            if (null === $number) {
                $number = null;
                $hasSymbolAdjacent = false;
                continue;
            }

            if ($hasSymbolAdjacent) {
                $partMap[] = [
                    'number' => $number,
                    'line' => $lineNumber,
                    'column_start' => $column - strlen($number),
                    'column_end' => $column - 1,
                    'symbol_adjacent' => $hasSymbolAdjacent,
                    'gear' => (function ($lines, $lineNumber, $start, $finish) {
                        for ($column = $start; $column <= $finish; $column++) {
                            $searchLines = [
                                $lineNumber - 1 => str_split($lines[$lineNumber - 1] ?? str_repeat('.', strlen($lines[1]))),
                                $lineNumber => str_split($lines[$lineNumber] ?? str_repeat('.', strlen($lines[1]))),
                                $lineNumber + 1 => str_split($lines[$lineNumber + 1] ?? str_repeat('.', strlen($lines[1]))),
                            ];

                            if ("*" === ($searchLines[$lineNumber - 1][$column - 1] ??= false)) {
                                return ($lineNumber - 1) . '-' . ($column - 1);
                            }

                            if ("*" === ($searchLines[$lineNumber - 1][$column] ??= false)) {
                                return ($lineNumber - 1) . '-' . ($column);
                            }

                            if ("*" === ($searchLines[$lineNumber - 1][$column + 1] ??= false)) {
                                return ($lineNumber - 1) . '-' . ($column + 1);
                            }

                            if ("*" === ($searchLines[$lineNumber][$column - 1] ??= false)) {
                                return ($lineNumber) . '-' . ($column - 1);
                            }

                            if ("*" === ($searchLines[$lineNumber][$column + 1] ??= false)) {
                                return ($lineNumber) . '-' . ($column + 1);
                            }

                            if ("*" === ($searchLines[$lineNumber + 1][$column - 1] ??= false)) {
                                return ($lineNumber + 1) . '-' . ($column - 1);
                            }

                            if ("*" === ($searchLines[$lineNumber + 1][$column] ??= false)) {
                                return ($lineNumber + 1) . '-' . ($column);
                            }

                            if ("*" === ($searchLines[$lineNumber + 1][$column + 1] ??= false)) {
                                return ($lineNumber + 1) . '-' . ($column + 1);
                            }
                        }

                        return null;
                    })(
                        $lines, $lineNumber, $column - strlen($number), $column - 1,
                    ),
                ];
            }

            $number = null;
            $hasSymbolAdjacent = false;
        }
    }

    $gearParts = [];

    foreach (array_filter($partMap, fn ($part) => null !== $part['gear']) as $part) {
        $gearParts[$part['gear']][] = $part;
    }

    foreach ($gearParts as $gearPart) {
        if (2 !== count($gearPart)) {
            continue;
        }

        $values = array_column($gearPart, 'number');
        $total += array_product($values);
    }

    return $total;
}

check('2023 Day 3 Part 2 Example', '2023/inputs/day-3/part-2-example.txt', part2(...), 467835);
produce('2023 Day 3 Part 2', '2023/inputs/day-3/input.txt', part2(...));
