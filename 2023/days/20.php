<?php

namespace AOC2023\Day20;

use SplQueue;

function part1(string $input): int
{
    $lines = explode(PHP_EOL, rtrim($input, PHP_EOL));
    $modules = [];
    $broadcast_targets = [];

    foreach ($lines as $line) {
        [$left, $right] = explode(' -> ', trim($line));
        $outputs = explode(', ', $right);

        if ('broadcaster' === $left) {
            $broadcast_targets = $outputs;
            continue;
        }

        $type = $left[0];
        $name = substr($left, 1);

        $modules[$name] = (object) [
            'name' => $name,
            'type' => $type,
            'outputs' => $outputs,
            'memory' => match ($type) {
                '%' => 'off',
                default => [],
            },
        ];
    }

    foreach ($modules as $name => $module) {
        foreach ($module->outputs as $output) {
            if (
                array_key_exists($output, $modules)
                && '&' === $modules[$output]->type
            ) {
                $modules[$output]->memory[$name] = 'low';
            }
        }
    }

    $low = $high = 0;

    for ($i = 0; $i < 1000; $i++) {
        ++$low;
        $queue = [];

        foreach ($broadcast_targets as $target) {
            $queue[] = [
                'broadcaster',
                $target,
                'low',
            ];
        }

        while (! empty($queue)) {
            [$origin, $target, $pulse] = array_shift($queue);

            match ($pulse) {
                'low' => ++$low,
                'high' => ++$high,
            };

            if (! array_key_exists($target, $modules)) {
                continue;
            }

            $module = $modules[$target];

            if ('%' === $module->type) {
                if ('low' === $pulse) {
                    $module->memory = 'off' === $module->memory ? 'on' : 'off';
                    $outgoing = 'on' === $module->memory ? 'high' : 'low';

                    foreach ($module->outputs as $target) {
                        $queue[] = [
                            $module->name,
                            $target,
                            $outgoing,
                        ];
                    }
                }

                continue;
            }

            $module->memory[$origin] = $pulse;
            $outgoing = in_array('low', $module->memory) ? 'high' : 'low';

            foreach ($module->outputs as $target) {
                $queue[] = [
                    $module->name,
                    $target,
                    $outgoing,
                ];
            }
        }
    }

    return $low * $high;
}

check('2023 Day 20 Part 1 Example', '2023/inputs/day-20/part-1-example.txt', part1(...), 32000000);
produce('2023 Day 20 Part 1', '2023/inputs/day-20/input.txt', part1(...));

function part2(string $input): int
{
    $lines = explode(PHP_EOL, rtrim($input, PHP_EOL));
    $modules = [];
    $broadcast_targets = [];

    foreach ($lines as $line) {
        [$left, $right] = explode(' -> ', trim($line));
        $outputs = explode(', ', $right);

        if ('broadcaster' === $left) {
            $broadcast_targets = $outputs;

            continue;
        }

        $type = $left[0];
        $name = substr($left, 1);

        $modules[$name] = (object) [
            'name' => $name,
            'type' => $type,
            'outputs' => $outputs,
            'memory' => match ($type) {
                '%' => 'off',
                default => [],
            },
        ];
    }

    foreach ($modules as $name => $module) {
        foreach ($module->outputs as $output) {
            if (
                array_key_exists($output, $modules)
                && '&' === $modules[$output]->type
            ) {
                $modules[$output]->memory[$name] = 'lo';
            }
        }
    }

    $feed = null;

    foreach ($modules as $name => $module) {
        if (in_array('rx', $module->outputs, true)) {
            $feed = $name;
            break;
        }
    }

    $cycle_lengths = array();
    $seen = array();

    foreach ($modules as $name => $module) {
        if (in_array($feed, $module->outputs, true)) {
            $seen[$name] = 0;
        }
    }

    $presses = 0;

    while (true) {
        ++$presses;
        $queue = new SplQueue();

        foreach ($broadcast_targets as $target) {
            $queue->enqueue(['broadcaster', $target, 'lo']);
        }

        while (! $queue->isEmpty()) {
            [$origin, $target, $pulse] = $queue->dequeue();

            if (! array_key_exists($target, $modules)) {
                continue;
            }

            $module = $modules[$target];

            if (
                $feed === $module->name
                && 'hi' === $pulse
            ) {
                ++$seen[$origin];

                if (! array_key_exists($origin, $cycle_lengths)) {
                    $cycle_lengths[$origin] = $presses;
                } else {
                    assert($presses === $seen[$origin] * $cycle_lengths[$origin]);
                }

                if (count($seen) === count(array_filter($seen))) {
                    $target = 1;

                    foreach ($cycle_lengths as $cycle_length) {
                        $target = gmp_lcm($target, $cycle_length);
                    }

                    return gmp_intval($target);
                }
            }

            if ('%' === $module->type) {
                if ('lo' === $pulse) {
                    $module->memory = $module->memory === 'off' ? 'on' : 'off';
                    $outgoing = $module->memory === 'on' ? 'hi' : 'lo';

                    foreach ($module->outputs as $target) {
                        $queue->enqueue(array($module->name, $target, $outgoing));
                    }
                }
            } else {
                $module->memory[$origin] = $pulse;
                $outgoing = in_array('lo', $module->memory, true) ? 'hi' : 'lo';

                foreach ($module->outputs as $target) {
                    $queue->enqueue([$module->name, $target, $outgoing]);
                }
            }
        }
    }
}

produce('2023 Day 20 Part 2', '2023/inputs/day-20/input.txt', part2(...));
