<?php
// Queue worker for production mail jobs.
// CLI (cron) runs without token; web run requires token.

define('WORKER_TOKEN', 'gtm-worker-run-20260305-prod');

if (php_sapi_name() !== 'cli') {
    if (!isset($_GET['token']) || $_GET['token'] !== WORKER_TOKEN) {
        http_response_code(403);
        header('Content-Type: text/plain; charset=utf-8');
        echo "forbidden\n";
        exit;
    }
    header('Content-Type: text/plain; charset=utf-8');
}

$root = __DIR__;
$apiDir = $root . '/api';
$jobsDir = $apiDir . '/jobs';
$processScript = $apiDir . '/process-job.php';
$lockPath = $jobsDir . '/.worker.lock';
$phpBinCandidates = ['/usr/bin/php8.2', '/usr/bin/php8.1', '/usr/bin/php', 'php'];

if (!is_dir($apiDir) || !file_exists($processScript)) {
    echo "setup_missing\n";
    exit;
}

if (!is_dir($jobsDir)) {
    mkdir($jobsDir, 0755, true);
}

$phpBin = null;
foreach ($phpBinCandidates as $bin) {
    if ($bin === 'php' || file_exists($bin)) {
        $phpBin = $bin;
        break;
    }
}

if ($phpBin === null) {
    echo "php_bin_not_found\n";
    exit;
}

$lockFp = fopen($lockPath, 'c');
if (!$lockFp) {
    echo "lock_open_failed\n";
    exit;
}
if (!flock($lockFp, LOCK_EX | LOCK_NB)) {
    echo "busy\n";
    fclose($lockFp);
    exit;
}

$files = glob($jobsDir . '/job_*.json');
if ($files === false) {
    $files = [];
}

$processed = 0;
$failed = 0;
foreach ($files as $jobFile) {
    $jobBase = basename($jobFile, '.json');
    // Run from api/ so relative template includes keep working.
    $cmd = 'cd ' . escapeshellarg($apiDir) . ' && ' . escapeshellcmd($phpBin) . ' process-job.php ' . escapeshellarg($jobBase) . ' >/dev/null 2>&1';
    $rc = 0;
    $out = [];
    exec($cmd, $out, $rc);
    $processed++;

    if (file_exists($jobFile)) {
        $failed++;
    }
}

$remaining = glob($jobsDir . '/job_*.json');
$remainingCount = is_array($remaining) ? count($remaining) : 0;

echo "php_bin={$phpBin}\n";
echo "processed={$processed}\n";
echo "failed={$failed}\n";
echo "remaining={$remainingCount}\n";

flock($lockFp, LOCK_UN);
fclose($lockFp);
