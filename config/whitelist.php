<?php
/**
 * ステージング環境用メールホワイトリスト
 * ここに記載されたメールアドレスはフリーメールブロックを回避できる
 *
 * このファイルは xserver ステージング環境専用。
 * Rituの納品物には含まれない。
 */

function getEmailWhitelist(): array
{
    // .env の EMAIL_WHITELIST（カンマ区切り対応）
    $envList = env('EMAIL_WHITELIST', '');
    if (!empty($envList)) {
        return array_map('trim', explode(',', $envList));
    }
    return [];
}

function isWhitelistedEmail(string $email): bool
{
    return in_array(strtolower(trim($email)), array_map('strtolower', getEmailWhitelist()), true);
}
