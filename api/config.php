<?php
require_once __DIR__ . '/../config/env.php';

return [
    // ======================================================
    // PUBLIC USER EMAIL SETTINGS (used inside email body)
    // ======================================================
    "PUBLIC_USER_EMAIL_SUBJECT_EN" => env('PUBLIC_USER_EMAIL_SUBJECT_EN', "【Go-to-Market】Maturity Assessment Report"),
    "PUBLIC_USER_EMAIL_SUBJECT_JP" => env('PUBLIC_USER_EMAIL_SUBJECT_JP', "【Go-to-Market】成熟度診断レポート送付のご案内"),

    "PUBLIC_USER_EMAIL_BOOKING_URL_EN" => env('PUBLIC_USER_EMAIL_BOOKING_URL_EN', "https://go-to-market.jp/en/#contact"),
    "PUBLIC_USER_EMAIL_BOOKING_URL_JP" => env('PUBLIC_USER_EMAIL_BOOKING_URL_JP', "https://go-to-market.jp/#contact"),

    "PUBLIC_USER_EMAIL_PRIVACY_URL_EN" => env('PUBLIC_USER_EMAIL_PRIVACY_URL_EN', "https://go-to-market.jp/en/privacy-policy/"),
    "PUBLIC_USER_EMAIL_PRIVACY_URL_JP" => env('PUBLIC_USER_EMAIL_PRIVACY_URL_JP', "https://go-to-market.jp/privacy-policy/"),
    "PUBLIC_USER_EMAIL_CONSULTATION_URL_JP" => env('PUBLIC_USER_EMAIL_CONSULTATION_URL_JP', "https://go-to-market.jp/"),
    "PUBLIC_USER_EMAIL_SITE_URL_JP" => env('PUBLIC_USER_EMAIL_SITE_URL_JP', "https://go-to-market.jp/"),
    "PUBLIC_USER_EMAIL_CONTACT_URL_JP" => env('PUBLIC_USER_EMAIL_CONTACT_URL_JP', "https://go-to-market.jp/#contact"),
    "PUBLIC_USER_EMAIL_POLICY_URL_JP" => env('PUBLIC_USER_EMAIL_POLICY_URL_JP', "https://go-to-market.jp/privacy-policy/"),
    "PUBLIC_USER_EMAIL_CONSULTATION_URL_EN" => env('PUBLIC_USER_EMAIL_CONSULTATION_URL_EN', "https://go-to-market.jp/en/"),
    "PUBLIC_USER_EMAIL_SITE_URL_EN" => env('PUBLIC_USER_EMAIL_SITE_URL_EN', "https://go-to-market.jp/en/"),
    "PUBLIC_USER_EMAIL_CONTACT_URL_EN" => env('PUBLIC_USER_EMAIL_CONTACT_URL_EN', "https://go-to-market.jp/en/#contact"),
    "PUBLIC_USER_EMAIL_POLICY_URL_EN" => env('PUBLIC_USER_EMAIL_POLICY_URL_EN', "https://go-to-market.jp/en/privacy-policy/"),

    // ======================================================
    // SMTP CONFIG
    // ======================================================
    "SMTP_HOST"     => env('SMTP_HOST', ''),
    "SMTP_PORT"     => (int) env('SMTP_PORT', 587),
    "SMTP_SECURE"   => env('SMTP_SECURE', 'tls'),
    "SMTP_USER"     => env('SMTP_USER', ''),
    "SMTP_PASSWORD" => env('SMTP_PASSWORD', ''),

    // ======================================================
    // USER EMAIL CONFIG
    // ======================================================
    "EMAIL_SEND_USER_COPY" => env('EMAIL_SEND_USER_COPY', 'true'),
    "EMAIL_USER_FROM"      => env('SMTP_FROM', env('SMTP_USER', 'noreply@go-to-market.jp')),
    "EMAIL_USER_FROM_NAME" => env('SMTP_FROM_NAME', 'Go-to-Market'),
    "FROM_MAIL"            => env('SMTP_FROM', env('SMTP_USER', 'noreply@go-to-market.jp')),
    "FROM_NAME"            => env('SMTP_FROM_NAME', 'Go-to-Market'),
    "EMAIL_USER_REPLY_TO"  => env('EMAIL_USER_REPLY_TO', 'support@go-to-market.jp'),
    "EMAIL_ATTACH_USER_PDF"=> env('EMAIL_ATTACH_USER_PDF', 'true'),

    // ======================================================
    // ADMIN EMAIL CONFIG
    // ======================================================
    "ADMIN_EMAIL"           => env('ADMIN_EMAIL', 'contact@go-to-market.jp'),
    "EMAIL_ADMIN_FROM"      => env('EMAIL_ADMIN_FROM', env('SMTP_FROM', env('SMTP_USER', 'noreply@go-to-market.jp'))),
    "EMAIL_ATTACH_ADMIN_PDF"=> env('EMAIL_ATTACH_ADMIN_PDF', 'true'),

    // ======================================================
    // OPTIONAL
    // ======================================================
    "EMAIL_BCC" => env('EMAIL_BCC', ''),
];
