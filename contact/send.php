<?php
header('Content-Type: application/json; charset=UTF-8');
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once(__DIR__ . '/src/PHPMailer.php');
require_once(__DIR__ . '/src/SMTP.php');
require_once(__DIR__ . '/src/Exception.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$config = include(__DIR__ . '/secure/config.php');

// ▼ 言語判定（デフォルトは日本語）
$lang = $_POST['lang'] ?? 'ja';

// ▼ フォーム内容取得
$name    = trim($_POST['name']    ?? '');
$email   = trim($_POST['email']   ?? '');
$message = trim($_POST['message'] ?? '');

// ▼ 必須チェック
if ($name === '' || $email === '' || $message === '') {
    echo json_encode([
        'success' => false,
        'message' => ($lang === 'en'
            ? 'Required fields are missing.'
            : '必須項目が入力されていません。'
        )
    ]);
    exit;
}

// ▼ メール本文（管理者向け）
if ($lang === 'en') {
    $body =
"【Contact Form Submission】

Name: {$name}
Email: {$email}

----------------------
{$message}
----------------------

This email was sent from the Go-to-Market Consulting Service website.
";
    $subject_admin = "【Go-to-Market】英語版フォームよりお問い合わせ";
} else {
    $body =
"【お問い合わせ内容】

お名前：{$name}
メール：{$email}

----------------------
{$message}
----------------------

このメールはGo-to-Market コンサルティングサービスフォームから送信されました。
";
    $subject_admin = "【Go-to-Market】お問い合わせがありました";
}

// ▼ PHPMailer（管理者向け送信）
$mail = new PHPMailer(true);

try {

    // ▼ SMTP（Google Workspace SMTP リレー）
    $mail->isSMTP();
    $mail->Host       = $config['smtp_host'];     // smtp-relay.gmail.com
    $mail->Port       = $config['smtp_port'];     // 587
    $mail->SMTPSecure = $config['smtp_secure'];   // tls

    $mail->SMTPAuth   = (bool) ($config['smtp_auth'] ?? false);
    if ($mail->SMTPAuth) {
        $mail->Username = $config['smtp_user'];
        $mail->Password = $config['smtp_pass'];
    }

    $mail->setFrom($config['smtp_from'], $config['smtp_from_name']);
    $mail->addAddress($config['admin_email'] ?? $config['smtp_from'], 'Contact Admin');
    $mail->addReplyTo($email, $name);

    $mail->CharSet  = 'UTF-8';
    $mail->Encoding = 'base64';

    $mail->Subject = $subject_admin;
    $mail->Body    = $body;

    $mail->send();

    // ▼ 自動返信メール（ユーザー向け）
    $auto = new PHPMailer(true);
    $auto->isSMTP();
    $auto->Host       = $config['smtp_host'];
    $auto->Port       = $config['smtp_port'];
    $auto->SMTPSecure = $config['smtp_secure'];
    $auto->SMTPAuth   = (bool) ($config['smtp_auth'] ?? false);
    if ($auto->SMTPAuth) {
        $auto->Username = $config['smtp_user'];
        $auto->Password = $config['smtp_pass'];
    }

    $auto->setFrom($config['smtp_from'], 'Go-to-Market Consulting Service');
    $auto->addAddress($email, $name);

    $auto->CharSet  = 'UTF-8';
    $auto->Encoding = 'base64';

    if ($lang === 'en') {
        $auto->Subject = "Thank you for your inquiry";
        $auto->Body =
"Dear {$name},

Thank you for contacting us.
We have received your message as below:

----------------------
{$message}
----------------------

Our team will get back to you shortly.

Go-to-Market Consulting Service
Catalyst Inc.
https://catalyst.site/en/
";
    } else {
        $auto->Subject = "お問い合わせありがとうございます";
        $auto->Body =
"{$name} 様

お問い合わせありがとうございます。

以下の内容で承りました。

----------------------
{$message}
----------------------

担当者よりご連絡いたしますので、
今しばらくお待ちください。

Catalyst株式会社
Go-to-Marketサービス事務局
https://catalyst.site
";
    }

    $auto->send();

    echo json_encode([
        'success' => true,
        'message' => ($lang === 'en'
            ? 'Your message was sent.'
            : '送信しました。'
        )
    ]);
    exit;

} catch (Exception $e) {

    echo json_encode([
        'success' => false,
        'message' => ($lang === 'en'
            ? 'Mail sending failed.'
            : 'メール送信に失敗しました。'
        ),
        'error' => $mail->ErrorInfo
    ]);
    exit;
}
