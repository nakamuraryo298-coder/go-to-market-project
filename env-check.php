<?php
require_once __DIR__ . '/config/env.php';
header('Content-Type: text/plain; charset=utf-8');

$envFile = __DIR__ . '/.env';
echo "ENV_FILE=" . (file_exists($envFile) ? 'yes' : 'no') . PHP_EOL;
echo "ENV_READABLE=" . (is_readable($envFile) ? 'yes' : 'no') . PHP_EOL;
echo "BASE_URL=" . env('BASE_URL', '(not set)') . PHP_EOL;
echo "PUTENV_EXISTS=" . (function_exists('putenv') ? 'yes' : 'no') . PHP_EOL;
echo "DISABLED_FUNCS=" . ini_get('disable_functions') . PHP_EOL;
echo "GETENV_BASE_URL=" . (getenv('BASE_URL') ?: '(not set)') . PHP_EOL;
echo "ENV_BASE_URL=" . ($_ENV['BASE_URL'] ?? '(not set)') . PHP_EOL;
$lines = file(__DIR__ . '/.env', FILE_IGNORE_NEW_LINES);
echo "LINE0_HEX=" . bin2hex($lines[0] ?? '') . PHP_EOL;
