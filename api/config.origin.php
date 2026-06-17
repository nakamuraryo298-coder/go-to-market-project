<?php
return [

    // ======================================================
    // PUBLIC USER EMAIL SETTINGS (used inside email body)
    // ======================================================
    "PUBLIC_USER_EMAIL_SUBJECT_EN" => "[Go-to-Market] Maturity Assessment Report",
    "PUBLIC_USER_EMAIL_SUBJECT_JP" => "【Go-to-Market】成熟度診断レポート送付のご案内",

    "PUBLIC_USER_EMAIL_BOOKING_URL_EN" => "https://go-to-market.jp/en/#contact",
    "PUBLIC_USER_EMAIL_BOOKING_URL_JP" => "https://go-to-market.jp/#contact",

    "PUBLIC_USER_EMAIL_PRIVACY_URL_EN" => "https://go-to-market.jp/en/privacy-policy/",
    "PUBLIC_USER_EMAIL_PRIVACY_URL_JP" => "https://go-to-market.jp/privacy-policy/",

    // ======================================================
    // SMTP CONFIG (server-only)
    // ======================================================
    // "SMTP_HOST"     => "smtp.hostinger.com",
    // "SMTP_PORT"     => 587,
    // "SMTP_SECURE"   => "false",
    // "SMTP_USER"     => "info@workprogress.co.in",
    // "SMTP_PASSWORD" => "WorkProgressMail@2025",

    "SMTP_HOST"     => "mail.rewainfotech.com",
    "SMTP_PORT"     => 465,
    "SMTP_SECURE"   => "false",
    "SMTP_USER"     => "testsmtp@rewainfotech.com",
    "SMTP_PASSWORD" => "Q)DBYQLqd2Ps",


    // ======================================================
    // USER EMAIL CONFIG
    // ======================================================
    "EMAIL_SEND_USER_COPY" => "true",
    "EMAIL_USER_FROM"      => "info@workprogress.co.in",
    "EMAIL_USER_REPLY_TO"  => "support@go-to-market.jp",
    "EMAIL_ATTACH_USER_PDF"=> "true",

    // ======================================================
    // ADMIN EMAIL CONFIG
    // ======================================================
    "ADMIN_EMAIL"           => "info@workprogress.co.in",
    "EMAIL_ADMIN_FROM"      => "system@go-to-market.jp",
    "EMAIL_ATTACH_ADMIN_PDF"=> "true"
];
