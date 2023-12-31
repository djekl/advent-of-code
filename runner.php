#!/usr/bin/env php
<?php

require_once __DIR__ . '/vendor/autoload.php';

$task = $argv[1];

if (! file_exists(base_path("$task.php"))) {
    echo "File {$task} not found.\n";
    exit(1);
}

require_once base_path("$task.php");

try {
    $redis = redisInstance();
    $redis->flushAll();
} catch (Exception $e) {}
