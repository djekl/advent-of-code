<?php

namespace AOC2023\Day7;

function part1($input)
{
    $values = [
        'T' => 10,
        'J' => 11,
        'Q' => 12,
        'K' => 13,
        'A' => 14,
    ];

    $sets = [];

    foreach (explode(PHP_EOL, $input) as $line) {
        if ('' === $line) {
            continue;
        }

        [
            $hand,
            $bid,
        ] = explode(' ', trim($line));

        $cards = str_split($hand);
        $counts = array_count_values($cards);
        arsort($counts);

        $handStrength = match (count($counts)) {
            1 => 7, // Five of a kind
            2 => 4 === max($counts) ? 6 : 5, // Four of a kind : Full house
            3 => 3 === max($counts) ? 4 : 3, // Three of a kind : Two pair
            4 => 2, // One pair
            default => 1, // High card
        };

        $sorted_cards = [];
        foreach ($cards as $i => $card) {
            $sorted_cards[] = $values[$card] ??= (int) $card;
        }

        $sets[] = [
            'hand' => $hand,
            'bid' => (int) $bid,
            'strength' => array_merge([$handStrength], $sorted_cards),
        ];
    }

    usort($sets, static function (array $a, array $b): int {
        foreach (array_keys($a['strength']) as $i) {
            $weight = $a['strength'][$i] <=> $b['strength'][$i];

            if ($weight !== 0) {
                return $weight;
            }
        }

        return 0;
    });

    $sum = 0;

    foreach ($sets as $i => $set) {
        $sum += ($i + 1) * $set['bid'];
    }

    return $sum;
}

check('2023 Day 7 Part 1 Example', '2023/inputs/day-7/part-1-example.txt', part1(...), 6440);
produce('2023 Day 7 Part 1', '2023/inputs/day-7/input.txt', part1(...));

function part2(string $input): int
{
    $values = [
        'T' => 10,
        // 'J' => 11,
        'Q' => 12,
        'K' => 13,
        'A' => 14,
    ];

    $sets = [];

    foreach (explode(PHP_EOL, $input) as $line) {
        if ('' === $line) {
            continue;
        }

        [
            $hand,
            $bid,
        ] = explode(' ', trim($line));

        $cards = str_split($hand);
        $counts = array_count_values($cards);
        arsort($counts);

        $handCount = $counts;
        unset($handCount['J']);

        $jokers = array_key_exists('J', $counts) ? $counts['J'] : 0;

        if (false !== strpos($hand, 'J')) {
            $handCount = array_map(fn ($count) => $count + $jokers, $handCount);

            // hand is equal to 5 jokers
            if (empty($handCount)) {
                $handCount = array_count_values(str_split('AAAAA'));
            }
        }

        $handStrength = match (count($handCount)) {
            1 => 7, // Five of a kind
            2 => 4 === max($handCount) ? 6 : 5, // Four of a kind : Full house
            3 => 3 === max($handCount) ? 4 : 3, // Three of a kind : Two pair
            4 => 2, // One pair
            default => 1, // High card
        };

        $sorted_cards = [];
        foreach ($cards as $i => $card) {
            $sorted_cards[] = $values[$card] ??= (int) $card;
        }

        $sets[] = [
            'hand' => $hand,
            'bid' => (int) $bid,
            'strength' => array_merge([$handStrength], $sorted_cards),
        ];
    }

    usort($sets, static function (array $a, array $b): int {
        foreach (array_keys($a['strength']) as $i) {
            $weight = $a['strength'][$i] <=> $b['strength'][$i];

            if ($weight !== 0) {
                return $weight;
            }
        }

        return 0;
    });

    $sum = 0;

    foreach ($sets as $i => $set) {
        $sum += ($i + 1) * $set['bid'];
    }

    return $sum;
}

check('2023 Day 7 Part 2 Example', '2023/inputs/day-7/part-2-example.txt', part2(...), 5905);
produce('2023 Day 7 Part 2', '2023/inputs/day-7/input.txt', part2(...));
