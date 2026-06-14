<?php
/**
 * 環境変数ヘルパー
 * Docker環境とローカル環境の両方に対応
 */

// .envファイルを読み込み（存在する場合）
$envFile = dirname(__DIR__) . '/.env';
if (file_exists($envFile) && !isset($GLOBALS['_ENV_LOADED'])) {
    $GLOBALS['_ENV_LOADED'] = true;
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        // コメント行をスキップ
        if (strpos(trim($line), '#') === 0) {
            continue;
        }
        // KEY=VALUE形式をパース
        if (strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);
            // クォートを除去
            $value = trim($value, '"\'');
            putenv("$key=$value");
            $_ENV[$key] = $value;
        }
    }
}

/**
 * 環境変数を取得（デフォルト値付き）
 */
function env(string $key, $default = null)
{
    $value = getenv($key);

    if ($value === false) {
        return $default;
    }

    // 型変換
    switch (strtolower($value)) {
        case 'true':
        case '(true)':
            return true;
        case 'false':
        case '(false)':
            return false;
        case 'null':
        case '(null)':
            return null;
        case 'empty':
        case '(empty)':
            return '';
    }

    return $value;
}

/**
 * 開発環境かどうか
 */
function isDevelopment(): bool
{
    return env('APP_ENV', 'development') === 'development';
}

/**
 * 本番環境かどうか
 */
function isProduction(): bool
{
    return env('APP_ENV', 'development') === 'production';
}
