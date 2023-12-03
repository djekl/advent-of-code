<?php

namespace AOC2023\Day3;

function part1(string $input): int
{
    $lines = explode(PHP_EOL, $input);
    $map = [];
    $total = 0;
    $numbers = [];

    foreach ($lines as $lineNUmber => $line) {
        if ('' === $line) {
            continue;
        }

        foreach (str_split($line) as $column => $value) {
            if ('.' === $value) {
                continue;
            }

            if (is_numeric($value)) {
                $map['numbers'][$lineNUmber][$column] = $value;
            } else {
                $map['symbols'][$lineNUmber][] = $column;
            }
        }
    }

    foreach ($map['symbols'] as $lineNumber => $line) {
        foreach ($line as $columnNumber => $column) {
            foreach (
                [
                    $lineNumber - 1,
                    $lineNumber,
                    $lineNumber + 1,
                ] as $i
            ) {
                if (! array_key_exists($i, $map['numbers'])) {
                    continue;
                }

                $number = null;
                $_columnNumber = $columnNumber - 1;

                while (array_key_exists($_columnNumber, $map['numbers'][$i])) {
                    $number .= $map['numbers'][$i][$_columnNumber];
                    $_columnNumber--;
                }

                if (array_key_exists($columnNumber, $map['numbers'][$i])) {
                    $number .= $map['numbers'][$i][$columnNumber];
                } else {
                    if (null !== $number) {
                        $numbers[] = (int) strrev($number);
                        $total += (int) strrev($number);
                    }

                    $number = null;
                }

                $_columnNumber = $columnNumber + 1;

                while (array_key_exists($_columnNumber, $map['numbers'][$i])) {
                    $number .= $map['numbers'][$i][$_columnNumber];
                    $_columnNumber++;
                }

                if (null !== $number) {
                    $numbers[] = (int) $number;
                    $total += (int) $number;
                }
            }
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
