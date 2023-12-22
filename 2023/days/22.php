<?php

namespace AOC2023\Day22;

function extractAndSortBricks(string $input): array
{
    $lines = explode(PHP_EOL, trim($input, PHP_EOL));
    $bricks = [];

    foreach ($lines as $line) {
        $line = trim($line);
        $line = str_replace('~', ',', $line);

        $bricks[] = array_map(
            static fn ($value) => (int) $value,
            explode(',', $line)
        );
    }

    usort($bricks, static function($a, $b) {
        return $a[2] <=> $b[2];
    });

    foreach ($bricks as $index => &$brick) {
        $max_z = 1;

        foreach (array_slice($bricks, 0, $index) as $check) {
            if (overlaps($brick, $check)) {
                $max_z = max($max_z, $check[5] + 1);
            }
        }

        $brick[5] -= $brick[2] - $max_z;
        $brick[2] = $max_z;
    }
    unset($brick);

    usort($bricks, static function($a, $b) {
        return $a[2] <=> $b[2];
    });

    return $bricks;
}

function overlaps($a, $b): bool
{
    return $a !== $b
        && max($a[0], $b[0]) <= min($a[3], $b[3])
        && max($a[1], $b[1]) <= min($a[4], $b[4]);
}

function extractSupportingBricks(array $bricks): array
{
    $supporting = $supportedBy = array_fill(0, count($bricks), []);

    foreach ($bricks as $upperKey => $upper) {
        foreach ($bricks as $lowerKey => $lower) {
            if (overlaps($lower, $upper) && $upper[2] === $lower[5] + 1) {
                $supporting[$lowerKey][] = $upperKey;
                $supportedBy[$upperKey][] = $lowerKey;
            }
        }
    }

    return [$supporting, $supportedBy];
}

function part1(string $input): int
{
    $bricks = extractAndSortBricks($input);
    [$supporting, $supportedBy] = extractSupportingBricks($bricks);

    $total = 0;

    foreach ($supporting as $supportedBricks) {
        $count = 0;

        foreach ($supportedBricks as $supportedBrick) {
            $count += count($supportedBy[$supportedBrick]);
        }

        if ($count >= 2) {
            $total++;
        }
    }

    return $total;
}

check('2023 Day 22 Part 1 Example', '2023/inputs/day-22/part-1-example.txt', part1(...), 5);
// produce('2023 Day 22 Part 1', '2023/inputs/day-22/input.txt', part1(...));

function part2(string $input): int
{
    $bricks = extractAndSortBricks($input);
    [$supporting, $supportedBy] = extractSupportingBricks($bricks);

    $total = 0;

    foreach (array_keys($bricks) as $brickIndex) {
        $queue = [];

        foreach ($supporting[$brickIndex] as $supportingBrick) {
            if (count($supportedBy[$supportingBrick]) === 1) {
                $queue[] = $supportingBrick;
            }
        }

        $falling = array_fill_keys(array_values($queue), true);
        $falling[$brickIndex] = true;

        while (! empty($queue)) {
            $brickIndex = array_shift($queue);

            foreach ($supporting[$brickIndex] as $supportingBrick) {
                if (
                    ! isset($falling[$supportingBrick])
                    && empty(array_diff_key($supportedBy[$supportingBrick], $falling))
                ) {
                    $queue[] = $supportingBrick;
                    $falling[$supportingBrick] = true;
                }
            }
        }

        $total += count($falling) - 1;
    }

    return $total;
}

check('2023 Day 22 Part 2 Example', '2023/inputs/day-22/part-2-example.txt', part2(...), 7);
// produce('2023 Day 22 Part 2', '2023/inputs/day-22/input.txt', part2(...));
