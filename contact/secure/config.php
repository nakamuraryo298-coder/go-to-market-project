<?php
$rootDir = dirname(__DIR__, 2);
require_once $rootDir . '/config/env.php';

$smtpUser = (string) env('CONTACT_SMTP_USER', env('SMTP_USER', ''));
$smtpPass = (string) env('CONTACT_SMTP_PASSWORD', env('SMTP_PASSWORD', ''));

return [
    // ▼ Google SMTP リレー
    'smtp_host'      => env('CONTACT_SMTP_HOST', env('SMTP_HOST', 'smtp-relay.gmail.com')),
    'smtp_port'      => (int) env('CONTACT_SMTP_PORT', env('SMTP_PORT', 587)),   // 25, 465 でも可。通常は 587 (TLS)
    'smtp_user'      => $smtpUser,
    'smtp_pass'      => $smtpPass,
    'smtp_secure'    => env('CONTACT_SMTP_SECURE', env('SMTP_SECURE', 'tls')), // TLS を推奨（ON にしてOK）
    'smtp_auth'      => env('CONTACT_SMTP_AUTH', ($smtpUser !== '' || $smtpPass !== '')),
    
    // ▼ 送信元
    'smtp_from'      => env('CONTACT_SMTP_FROM', env('SMTP_FROM', 'contact@catalyst.site')),
    'smtp_from_name' => env('CONTACT_SMTP_FROM_NAME', env('SMTP_FROM_NAME', 'LPフォーム')),
    'admin_email'    => env('CONTACT_ADMIN_EMAIL', env('ADMIN_EMAIL', env('SMTP_FROM', 'contact@catalyst.site'))),
];
/*return [
    'smtp_host'      => 'smtp.gmail.com',
    'smtp_port'      => 587, 
    'smtp_user'      => 'misaworks1111@gmail.com',
    'smtp_pass'      => 'wdxcmppbrrphztqt', 
    'smtp_secure'    => 'tls',
    'smtp_from'      => 'misaworks1111@gmail.com',
    'smtp_from_name' => 'LPフォーム',
];*/
