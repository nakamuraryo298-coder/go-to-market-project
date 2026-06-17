<?php
session_start();
include '../../inc/question-map.php';

/* ---------- Init ---------- */
$language = $_SESSION['lang'] ?? 'ja';
$answers  = $_SESSION['answers'] ?? [];

/* Dummy translator */
function t($k){ return $k; }

/* ---------- Question Map ---------- */
$questions = getQuestionMap($language, 't');

/* ---------- Group answers by category ---------- */
$categoryBuckets = [];

foreach ($questions as $index => $q) {
    if (!isset($answers[$index])) continue;

    $cat = $q['category'];
    $categoryBuckets[$cat][] = (int)$answers[$index];
}

/* ---------- Calculate averages ---------- */
$categoryScores = [];
$totalSum = 0;
$totalCount = 0;

foreach ($categoryBuckets as $cat => $scores) {
    $avg = round(array_sum($scores) / count($scores), 1);
    $categoryScores[$cat] = $avg;

    $totalSum += $avg;
    $totalCount++;
}

/* ---------- Overall ---------- */
$overallScore = $totalCount
    ? round($totalSum / $totalCount, 1)
    : 0;

/* ---------- Grade ---------- */
if ($overallScore >= 8) {
    $grade = 'A';
    $feedback = 'STRONG';
} elseif ($overallScore >= 6) {
    $grade = 'B';
    $feedback = 'MODERATE';
} else {
    $grade = 'C';
    $feedback = 'WEAK';
}

/* ---------- Response ---------- */
echo json_encode([
    'assessmentResult' => [
        'categoryScores' => $categoryScores,
        'overallScore'   => $overallScore,
        'grade'          => $grade,
        'feedbackLevel'  => $feedback
    ]
]);
