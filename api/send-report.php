<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// ===============================
// READ JSON
// ===============================
$payload = json_decode(file_get_contents("php://input"), true);

if (!$payload) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid JSON']);
    exit;
}

// ===============================
// CREATE JOB ID
// ===============================
$jobId = uniqid("job_", true);
$jobsDir = __DIR__ . "/jobs";

if (!is_dir($jobsDir)) {
    mkdir($jobsDir, 0755, true);
}

// Save payload
file_put_contents(
    "{$jobsDir}/{$jobId}.json",
    json_encode($payload)
);

// Send response first, then continue job processing server-side.
echo json_encode([
    'success' => true,
    'message' => 'Your report is being generated and will be emailed shortly.'
]);

if (function_exists('fastcgi_finish_request')) {
    fastcgi_finish_request();
}

// ===============================
// RUN JOB PROCESSOR
// ===============================
$processScript = __DIR__ . "/process-job.php";
$phpBinCandidates = ['/usr/bin/php8.2', '/usr/bin/php8.1', '/usr/bin/php', 'php'];
foreach ($phpBinCandidates as $phpBin) {
    if ($phpBin !== 'php' && !file_exists($phpBin)) {
        continue;
    }
    $cmd = escapeshellcmd($phpBin) . ' ' . escapeshellarg($processScript) . ' ' . escapeshellarg($jobId) . ' > /dev/null 2>&1';
    exec($cmd);
    break;
}

exit;
