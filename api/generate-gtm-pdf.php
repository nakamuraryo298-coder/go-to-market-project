<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

function gtm_pdf_jobs_dir(): string
{
    return __DIR__ . "/jobs";
}

function gtm_pdf_log_dispatch_error(string $message): void
{
    $jobsDir = gtm_pdf_jobs_dir();
    if (!is_dir($jobsDir)) {
        mkdir($jobsDir, 0755, true);
    }

    file_put_contents(
        "{$jobsDir}/error_log.txt",
        date('Y-m-d H:i:s') . " - " . $message . "\n",
        FILE_APPEND
    );
}

function gtm_pdf_function_available(string $functionName): bool
{
    if (!function_exists($functionName)) {
        return false;
    }

    $disabled = array_map('trim', explode(',', (string) ini_get('disable_functions')));
    return !in_array($functionName, $disabled, true);
}

function gtm_pdf_php_binary_candidates(): array
{
    $candidates = [];

    $envPhp = getenv('PHP_BINARY');
    if (is_string($envPhp) && $envPhp !== '') {
        $candidates[] = $envPhp;
    }

    if (defined('PHP_BINARY') && PHP_BINARY !== '') {
        $candidates[] = PHP_BINARY;
    }

    if (defined('PHP_BINDIR') && PHP_BINDIR !== '') {
        $candidates[] = PHP_BINDIR . '/php';
    }

    $candidates = array_merge($candidates, [
        '/usr/bin/php8.2',
        '/usr/bin/php8.1',
        '/usr/bin/php',
        'php',
    ]);

    return array_values(array_unique($candidates));
}

function gtm_pdf_find_php_binary(): ?string
{
    foreach (gtm_pdf_php_binary_candidates() as $phpBin) {
        if ($phpBin === 'php') {
            return $phpBin;
        }

        $binaryName = basename($phpBin);
        if (str_contains($binaryName, 'php-fpm') || str_contains($binaryName, 'php-cgi')) {
            continue;
        }

        if (is_file($phpBin) && is_executable($phpBin)) {
            return $phpBin;
        }
    }

    return null;
}

function gtm_pdf_dispatch_background_job(string $jobId): bool
{
    if (!gtm_pdf_function_available('exec')) {
        gtm_pdf_log_dispatch_error("Cannot dispatch {$jobId}: exec() is unavailable.");
        return false;
    }

    $phpBin = gtm_pdf_find_php_binary();
    if ($phpBin === null) {
        gtm_pdf_log_dispatch_error("Cannot dispatch {$jobId}: PHP CLI binary was not found.");
        return false;
    }

    $processScript = __DIR__ . "/process-job.php";
    $cmd = escapeshellarg($phpBin)
        . ' ' . escapeshellarg($processScript)
        . ' ' . escapeshellarg($jobId)
        . ' > /dev/null 2>&1 &';

    $exitCode = 1;
    exec($cmd, $output, $exitCode);

    if ($exitCode !== 0) {
        gtm_pdf_log_dispatch_error("Cannot dispatch {$jobId}: background command exited with {$exitCode}.");
        return false;
    }

    return true;
}

function gtm_pdf_finish_response(array $body): void
{
    $json = json_encode($body);
    if ($json === false) {
        $json = '{"success":false,"message":"Failed to encode response"}';
    }

    header('Connection: close');
    header('Content-Length: ' . strlen($json));
    echo $json;

    if (function_exists('fastcgi_finish_request')) {
        fastcgi_finish_request();
        return;
    }

    while (ob_get_level() > 0) {
        ob_end_flush();
    }
    flush();
}

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// ===============================
// READ PAYLOAD
// ===============================
$payload = json_decode(file_get_contents("php://input"), true);

if (!$payload) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Invalid JSON'
    ]);
    exit;
}

// ===============================
// CREATE JOB
// ===============================
$jobId   = uniqid("job_", true);
$jobsDir = gtm_pdf_jobs_dir();

if (!is_dir($jobsDir)) {
    mkdir($jobsDir, 0755, true);
}

file_put_contents(
    "{$jobsDir}/{$jobId}.json",
    json_encode($payload)
);

$dispatched = gtm_pdf_dispatch_background_job($jobId);

gtm_pdf_finish_response([
    'success' => true,
    'job_id' => $jobId,
    'message' => 'Your report is being generated and will be emailed shortly.'
]);

if (!$dispatched) {
    // Last-resort fallback for simple servers where background exec is disabled.
    // The client response has already been flushed, but this worker stays busy.
    $argv = [__DIR__ . "/process-job.php", $jobId];
    require __DIR__ . "/process-job.php";
}

exit;
