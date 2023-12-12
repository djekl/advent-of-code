<?php

function check(string $name, string|array $input, Closure $callback, mixed $expected): void
{
    $result = run($input, $callback);

    if ($result === $expected) {
        echo "\033[32m✔\033[0m {$name}\n";
    } else {
        echo "\033[31m✘\033[0m {$name} - expected {$expected}, got {$result}\n";
    }
}

function run(string|array $input, Closure $callback): mixed
{
    if (is_array($input) && file_exists($input[0])) {
        $input[0] = file_get_contents($input[0]);
    } elseif (file_exists($input)) {
        $input = [file_get_contents($input)];
    }

    return $callback(...$input);
}

function produce(string $name, string|array $input, Closure $callback): void
{
    $result = run($input, $callback);

    echo "{$name} produced the answer {$result}\n\n";
}

function base_path(string $path = ''): string
{
    return __DIR__ . ($path ? ('/' . $path) : $path);
}

/**
 * @throws RedisException
 */
function redisInstance(): Redis
{
    static $redis;

    if (! $redis) {
        $redis = new Redis();

        $redis->connect(
            host: '127.0.0.1',
            port: 6379,
        );
    }

    return $redis;
}
