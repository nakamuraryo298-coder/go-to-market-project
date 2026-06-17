<?php

ini_set('memory_limit', '1024M');
set_time_limit(300);

$jobId = $argv[1] ?? null;
if (!$jobId) exit;

$jobFile = __DIR__ . "/jobs/{$jobId}.json";
if (!file_exists($jobFile)) exit;

$payload = json_decode(file_get_contents($jobFile), true);

require __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/pdf-options.php';
$config = include __DIR__ . "/config.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dompdf\Dompdf;

try {

    // ===============================
    // EXTRACT DATA
    // ===============================
    $language = ($payload['language'] ?? 'en') === 'ja' ? 'ja' : 'en';
    $assessmentResult   = $payload['assessmentResult'];
    $answers            = $payload['answers'];
    $questions          = $payload['questions'];
    $selectedChallenges = $payload['selectedChallenges'];
    $user               = $payload['user'];

    $email        = $user['email'];
    $fullName     = $user['name'];
    $job_title    = $user['job_title'];
    $revenue_range= $user['revenue_range'];
    $department   = $user['department'];

    // ===============================
    // LOAD LANGUAGE FILE
    // ===============================
    $langFile = __DIR__ . "/lang/{$language}.json";
    if (!file_exists($langFile)) {
        $langFile = __DIR__ . "/lang/en.json";
    }
    $langData = json_decode(file_get_contents($langFile), true);
    $gtmChallenges = $langData['gtmChallenges'] ?? [];

    // ===============================
    // CREATE UPLOAD DIR
    // ===============================
    $uploadDir = __DIR__ . "/uploads/{$language}";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    // ===============================
    // GENERATE PDF
    // ===============================
    $options = gtm_create_pdf_options(__DIR__);

    $dompdf = new Dompdf($options);

    ob_start();
    if ($language === 'en') {
        include __DIR__ . "/templates/gtm-report.php";
    } else {
        include __DIR__ . "/templates/gtm-report-ja.php";
    }
    $html = ob_get_clean();

    $dompdf->loadHtml($html, 'UTF-8');
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    $filename = "GTM_Report_{$language}_" . date('Ymd_His') . ".pdf";
    $filePath = "{$uploadDir}/{$filename}";
    file_put_contents($filePath, $dompdf->output(gtm_pdf_output_options()));

    // ===============================
    // EMAIL SUBJECT
    // ===============================
    $subject = $language === 'ja'
        ? $config["PUBLIC_USER_EMAIL_SUBJECT_JP"]
        : $config["PUBLIC_USER_EMAIL_SUBJECT_EN"];

    // ===============================
    // EMAIL BODY (BILINGUAL)
    // ===============================
    if ($language === 'ja') {
        $consultationUrl = $config['PUBLIC_USER_EMAIL_CONSULTATION_URL_JP'] ?? 'https://go-to-market.jp/';
        $siteUrl = $config['PUBLIC_USER_EMAIL_SITE_URL_JP'] ?? 'https://go-to-market.jp/';
        $contactUrl = $config['PUBLIC_USER_EMAIL_CONTACT_URL_JP'] ?? 'https://go-to-market.jp/#contact';
        if ($contactUrl === 'https://go-to-market.jp/contact/' || $contactUrl === 'https://go-to-market.jp/contact') {
            $contactUrl = 'https://go-to-market.jp/#contact';
        }
        $privacyUrl = $config['PUBLIC_USER_EMAIL_POLICY_URL_JP'] ?? 'https://go-to-market.jp/privacy/';

        $plainText = <<<TEXT
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
Go-to-Marketサービス事務局からのお知らせ
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

この度は、GTM成熟度診断をご利用いただきありがとうございました。
診断レポートを添付しましたのでご確認ください。

無料相談を予約したい方はこちら
{$consultationUrl}

ご不明な点や本メールにお心当たりのない方は、下記よりお問い合わせください。

【連絡先】
Go-to-Marketサービス事務局
{$siteUrl}
お問い合わせフォーム: {$contactUrl}

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
このメールは、Go-to-Marketサービス事務局より自動的に送信されています。
返信メールでのお問い合わせは承りかねますので、あらかじめご了承ください。
▶︎プライバシーポリシーについてはこちら
{$privacyUrl}
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
TEXT;
        $plainText = str_replace(["\r\n", "\r"], "\n", trim($plainText));
        $plainText = str_replace("\n", "\r\n", $plainText);
        $consultationUrlEsc = htmlspecialchars($consultationUrl, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        $siteUrlEsc = htmlspecialchars($siteUrl, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        $contactUrlEsc = htmlspecialchars($contactUrl, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        $privacyUrlEsc = htmlspecialchars($privacyUrl, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        $htmlBody = <<<HTML
<!DOCTYPE html>
<html lang="ja">
<head><meta charset="UTF-8"></head>
<body>
  <table role="presentation" cellpadding="0" cellspacing="0" border="0" style="width:100%; max-width:720px; font-family:'Hiragino Kaku Gothic ProN','Yu Gothic','Meiryo',sans-serif; line-height:1.8; color:#111111;">
    <tr><td>━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━</td></tr>
    <tr><td style="font-weight:700;">Go-to-Marketサービス事務局からのお知らせ</td></tr>
    <tr><td>━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━</td></tr>
    <tr><td style="height:16px;"></td></tr>

    <tr><td>この度は、GTM成熟度診断をご利用いただきありがとうございました。</td></tr>
    <tr><td>診断レポートを添付しましたのでご確認ください。</td></tr>
    <tr><td style="height:16px;"></td></tr>

    <tr><td>無料相談を予約したい方はこちら</td></tr>
    <tr><td><a href="{$consultationUrlEsc}">{$consultationUrlEsc}</a></td></tr>
    <tr><td style="height:16px;"></td></tr>

    <tr><td>ご不明な点や本メールにお心当たりのない方は、下記よりお問い合わせください。</td></tr>
    <tr><td style="height:12px;"></td></tr>

    <tr><td>【連絡先】</td></tr>
    <tr><td>Go-to-Marketサービス事務局</td></tr>
    <tr><td><a href="{$siteUrlEsc}">{$siteUrlEsc}</a></td></tr>
    <tr><td>お問い合わせフォーム: <a href="{$contactUrlEsc}">{$contactUrlEsc}</a></td></tr>
    <tr><td style="height:16px;"></td></tr>

    <tr><td>━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━</td></tr>
    <tr><td>このメールは、Go-to-Marketサービス事務局より自動的に送信されています。</td></tr>
    <tr><td>返信メールでのお問い合わせは承りかねますので、あらかじめご了承ください。</td></tr>
    <tr><td>▶︎プライバシーポリシーについてはこちら</td></tr>
    <tr><td><a href="{$privacyUrlEsc}">{$privacyUrlEsc}</a></td></tr>
    <tr><td>━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━</td></tr>
  </table>
</body>
</html>
HTML;

    } else {

        $consultationUrlEn = $config['PUBLIC_USER_EMAIL_CONSULTATION_URL_EN'] ?? 'https://go-to-market.jp/en/';
        $siteUrlEn = $config['PUBLIC_USER_EMAIL_SITE_URL_EN'] ?? 'https://go-to-market.jp/en/';
        $contactUrlEn = $config['PUBLIC_USER_EMAIL_CONTACT_URL_EN'] ?? 'https://go-to-market.jp/en/#contact';
        if ($contactUrlEn === 'https://go-to-market.jp/en/#contact/') {
            $contactUrlEn = 'https://go-to-market.jp/en/#contact';
        }
        $privacyUrlEn = $config['PUBLIC_USER_EMAIL_POLICY_URL_EN'] ?? 'https://go-to-market.jp/en/privacy-policy/';

        $plainText = <<<TEXT
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
Notice from Go-to-Market Service
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

Thank you for using the GTM Maturity Assessment.
Your report is attached to this email. Please review it at your convenience.

If you would like to schedule a free consultation, please visit the link below:
{$consultationUrlEn}

If you have any questions or did not request this email, please contact us using the
information below.

【CONTACT INFORMATION】
Go-to-Market Service
{$siteUrlEn}
Contact Form: {$contactUrlEn}

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
This is an automated message sent by the Go-to-Market Service.
Please note that we cannot respond to replies sent to this email address.
▶︎For our Privacy Policy, please visit:
{$privacyUrlEn}
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
TEXT;
        $plainText = str_replace(["\r\n", "\r"], "\n", trim($plainText));
        $plainText = str_replace("\n", "\r\n", $plainText);
        $consultationUrlEnEsc = htmlspecialchars($consultationUrlEn, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        $siteUrlEnEsc = htmlspecialchars($siteUrlEn, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        $contactUrlEnEsc = htmlspecialchars($contactUrlEn, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        $privacyUrlEnEsc = htmlspecialchars($privacyUrlEn, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        $htmlBody = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"></head>
<body>
  <table role="presentation" cellpadding="0" cellspacing="0" border="0" style="width:100%; max-width:720px; font-family:Arial,sans-serif; line-height:1.8; color:#111111;">
    <tr><td>━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━</td></tr>
    <tr><td style="font-weight:700;">Notice from Go-to-Market Service</td></tr>
    <tr><td>━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━</td></tr>
    <tr><td style="height:16px;"></td></tr>

    <tr><td>Thank you for using the GTM Maturity Assessment.</td></tr>
    <tr><td>Your report is attached to this email. Please review it at your convenience.</td></tr>
    <tr><td style="height:16px;"></td></tr>

    <tr><td>If you would like to schedule a free consultation, please visit the link below:</td></tr>
    <tr><td><a href="{$consultationUrlEnEsc}">{$consultationUrlEnEsc}</a></td></tr>
    <tr><td style="height:16px;"></td></tr>

    <tr><td>If you have any questions or did not request this email, please contact us using the information below.</td></tr>
    <tr><td style="height:12px;"></td></tr>

    <tr><td>【CONTACT INFORMATION】</td></tr>
    <tr><td>Go-to-Market Service</td></tr>
    <tr><td><a href="{$siteUrlEnEsc}">{$siteUrlEnEsc}</a></td></tr>
    <tr><td>Contact Form: <a href="{$contactUrlEnEsc}">{$contactUrlEnEsc}</a></td></tr>
    <tr><td style="height:16px;"></td></tr>

    <tr><td>━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━</td></tr>
    <tr><td>This is an automated message sent by the Go-to-Market Service.</td></tr>
    <tr><td>Please note that we cannot respond to replies sent to this email address.</td></tr>
    <tr><td>▶︎For our Privacy Policy, please visit:</td></tr>
    <tr><td><a href="{$privacyUrlEnEsc}">{$privacyUrlEnEsc}</a></td></tr>
    <tr><td>━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━</td></tr>
  </table>
</body>
</html>
HTML;
    }
    // ===============================
    // SEND EMAIL
    // ===============================
    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host       = $config['SMTP_HOST'];
    $mail->SMTPAuth   = true;
    $mail->Username   = $config['SMTP_USER'];
    $mail->Password   = $config['SMTP_PASSWORD'];
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = $config['SMTP_PORT'];

    $mail->CharSet  = 'UTF-8';
    $mail->Encoding = 'base64';
    $mail->WordWrap = 78;
    $mail->isHTML(true);

    $mail->setFrom($config['FROM_MAIL'], $config['FROM_NAME']);
    $mail->addAddress($email, $fullName);
    $rawBcc = (string)($config['EMAIL_BCC'] ?? '');
    if ($rawBcc !== '') {
        $bccList = array_filter(array_map('trim', explode(',', $rawBcc)));
        foreach ($bccList as $bcc) {
            if (filter_var($bcc, FILTER_VALIDATE_EMAIL)) {
                $mail->addBCC($bcc);
            }
        }
    }
    $mail->Subject = $subject;
    $mail->Body    = $htmlBody;
    $mail->AltBody = $plainText;

    if (file_exists($filePath)) {
        $mail->addAttachment($filePath, $filename);
    }

    $mail->send();
    $mail->smtpClose();

    // DELETE JOB FILE
    unlink($jobFile);

} catch (Throwable $e) {

    file_put_contents(
        __DIR__ . "/jobs/error_log.txt",
        date('Y-m-d H:i:s') . " - " . $e->getMessage() . "\n",
        FILE_APPEND
    );
}
