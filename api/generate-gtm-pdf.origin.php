<?php
// =======================================
// ERROR REPORTING (DEV)
// =======================================
error_reporting(E_ALL);
ini_set('display_errors', 1);


// =======================================
// CORS
// =======================================
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// =======================================
// AUTOLOAD
// =======================================

$config = include __DIR__ . "/config.php";
require __DIR__ . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);
use Dompdf\Dompdf;
use Dompdf\Options;

// =======================================
// READ PAYLOAD
// =======================================
$payload = json_decode(file_get_contents("php://input"), true);

if (!$payload) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid JSON']);
    exit;
}

// =======================================
// EXTRACT DATA (FROM YOUR PAYLOAD)
// =======================================
$language           = ($payload['language'] ?? 'en') === 'ja' ? 'ja' : 'en';
$assessmentResult   = $payload['assessmentResult'];
$answers            = $payload['answers'];
$questions          = $payload['questions'];
$selectedChallenges = $payload['selectedChallenges'];
$user               = $payload['user'];
$email              = $user['email'];
$fullName           = $user['name'];
$job_title                      =   $payload['user']['job_title'];
$revenue_range                      =   $payload['user']['revenue_range'];
$department                      =   $payload['user']['department'];

// =======================================
// LOAD LANGUAGE FILE
// =======================================
$langFile = __DIR__ . "/lang/{$language}.json";
if (!file_exists($langFile)) {
    $langFile = __DIR__ . "/lang/en.json";
}

$langData = json_decode(file_get_contents($langFile), true);



$gtmChallenges = $langData['gtmChallenges'] ?? [];

// =======================================
// CREATE UPLOAD DIR
// =======================================
$uploadDir = __DIR__ . "/uploads/{$language}";
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// =======================================
// DOMPDF CONFIG
// =======================================
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isFontSubsettingEnabled', true); 
$options->set('isRemoteEnabled', true);
// $options->set('defaultFont', 'Noto Sans JP'); // safe default for Japanese

$dompdf = new Dompdf($options);

// =======================================
// RENDER TEMPLATE
// =======================================
ob_start();
if($language=='en'){
    include __DIR__ . "/templates/gtm-report.php";
}else{
    include __DIR__ . "/templates/gtm-report-ja.php";
}

$html = ob_get_clean();
// echo $html;die;
$dompdf->loadHtml($html, 'UTF-8');
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// =======================================
// SAVE PDF
// =======================================
$filename = "GTM_Report_{$language}_" . date('Ymd_His') . ".pdf";
$filePath = "{$uploadDir}/{$filename}";
file_put_contents($filePath, $dompdf->output());

// =======================================
// RESPONSE
// =======================================

// =======================================
// EMAIL SUBJECT
// =======================================
$subject = $language === 'ja'
    ? $config["PUBLIC_USER_EMAIL_SUBJECT_JP"]
    : $config["PUBLIC_USER_EMAIL_SUBJECT_EN"];

// =======================================
// EMAIL BODY
// =======================================
$htmlBody = ($language === 'ja') ? <<<HTML
<!DOCTYPE html>
<html lang="ja"><head><meta charset="UTF-8"></head><body>
<div class="container">
<hr>
<p><strong>Go-to-Marketサービスからのお知らせ</strong></p>
<hr>

<div class="section">
    <p>GTM成熟度アセスメントをご利用いただき、誠にありがとうございます。</p>
    <p>レポートを本メールに添付しておりますので、ご確認ください。</p>
</div>

<div class="section">
    <p>無料コンサルテーションをご希望の場合は、以下のリンクよりお申し込みください。</p>
    <p>
        <a href="https://go-to-market.jp/en/#contact">
            https://go-to-market.jp/en/#contact
        </a>
    </p>
</div>

<div class="section">
    <p>ご不明な点がある場合、または本メールに心当たりがない場合は、下記よりお問い合わせください。</p>
</div>

<div class="section">
    <h3>[お問い合わせ先]</h3>
    <p>Go-to-Marketサービス</p>
    <p>
        <a href="https://go-to-market.jp">
            https://go-to-market.jp
        </a>
    </p>
    <p>
        お問い合わせフォーム：
        <a href="{$config["PUBLIC_USER_EMAIL_BOOKING_URL_JP"]}">
            {$config["PUBLIC_USER_EMAIL_BOOKING_URL_JP"]}
        </a>
    </p>
</div>

<hr>

<div class="section footer">
    <p>本メールはGo-to-Marketサービスより自動送信されています。</p>
    <p>本メールへの返信には対応できませんので、あらかじめご了承ください。</p>
    <p>▶ プライバシーポリシー</p>
    <p>
        <a href="{$config["PUBLIC_USER_EMAIL_PRIVACY_URL_JP"]}">
            {$config["PUBLIC_USER_EMAIL_PRIVACY_URL_JP"]}
        </a>
    </p>
</div>
</div>
</body></html>
HTML
:
<<<HTML
<!DOCTYPE html>
<html lang="en"><head><meta charset="UTF-8"></head><body>
<div class="container">

<hr>
<p><strong>Notice from Go-to-Market Service</strong></p>
<hr>

<div class="section">
    <p>Thank you for using the GTM Maturity Assessment.</p>
    <p>Your report is attached to this email. Please review it at your convenience.</p>
</div>

<div class="section">
    <p>If you would like to schedule a free consultation, please visit the link below:</p>
    <p>
        <a href="https://go-to-market.jp/en/#contact">
            https://go-to-market.jp/en/#contact
        </a>
    </p>
</div>

<div class="section">
    <p>If you have any questions or did not request this email, please contact us using the information below.</p>
</div>

<div class="section">
    <h3>[CONTACT INFORMATION]</h3>
    <p>Go-to-Market Service</p>
    <p>
        <a href="https://go-to-market.jp/en/">
            https://go-to-market.jp/en/
        </a>
    </p>
    <p>
        Contact Form:
        <a href="{$config["PUBLIC_USER_EMAIL_BOOKING_URL_EN"]}">
            {$config["PUBLIC_USER_EMAIL_BOOKING_URL_EN"]}
        </a>
    </p>
</div>

<hr>

<div class="section footer">
    <p>This is an automated message sent by the Go-to-Market Service.</p>
    <p>Please note that we cannot respond to replies sent to this email address.</p>
    <p>▶︎ Privacy Policy</p>
    <p>
        <a href="{$config["PUBLIC_USER_EMAIL_PRIVACY_URL_EN"]}">
            {$config["PUBLIC_USER_EMAIL_PRIVACY_URL_EN"]}
        </a>
    </p>
</div>

<hr>

</div>
</body></html>
HTML;

$mail = new PHPMailer(true);

try {
    // SMTP
    $mail->isSMTP();
    $mail->isSMTP();
    $mail->Host       = $config['SMTP_HOST'];   // SMTP server
    $mail->SMTPAuth   = true;
    $mail->Username   = $config['SMTP_USER'];
    $mail->Password   = $config['SMTP_PASSWORD'];
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Encoding
    $mail->CharSet  = 'UTF-8';
    $mail->Encoding = 'base64';
    $mail->isHTML(true);

    // Mail headers
    $mail->setFrom('testsmtp@rewainfotech.com', 'Go To Market');
    $mail->addAddress($email, $fullName);
    $mail->addBCC('chandramanirinfo@gmail.com'); 

    $mail->Subject = $subject;
    $mail->Body    = $htmlBody;
    // $mail->AltBody = "Please find your GTM report attached.";

    // Attach PDF
    if (file_exists($filePath)) {
        $mail->addAttachment($filePath, $filename);
    } else {
        throw new Exception("Attachment missing: {$filePath}");
    }

    $mail->send();

    echo json_encode([
        'success' => true,
        'file'    => $filename,
        'path'    => "uploads/{$language}/{$filename}",
        'download_pdf'=>"https://gotomarketfrontend.rewainfotech.com/api/uploads/{$language}/{$filename}"
    ]);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $mail->ErrorInfo]);
}