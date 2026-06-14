<?php

/* ---------- Grade thresholds ---------- */
const GRADE_THRESHOLDS = [
    'S' => ['min' => 9.0, 'max' => 10.0],
    'A' => ['min' => 7.5, 'max' => 8.9],
    'B' => ['min' => 6.0, 'max' => 7.4],
    'C' => ['min' => 4.0, 'max' => 5.9],
    'D' => ['min' => 1.0, 'max' => 3.9],
];

/* ---------- Feedback thresholds ---------- */
const FEEDBACK_THRESHOLDS = [
    'STRONG'        => 7.0,
    'MODERATE_MIN'  => 4.0,
    'MODERATE_MAX'  => 6.9,
    'WEAK'          => 3.9,
];
function getCategoryStatusJA($categoryScore)
{
    // Round to 1 decimal place
    $x = round($categoryScore, 1);

    if ($x >= 7.0) {
        return [
            'status'     => 'Strong',
            'stageLabel' => 'Advanced',
            'actionType' => 'Maintain strengths, pursue advanced optimization'
        ];
    } elseif ($x >= 4.0) {
        $label = ($x >= 6.0) ? 'Competent' : 'Developing';

        return [
            'status'     => 'Moderate',
            'stageLabel' => $label,
            'actionType' => 'Optimize existing processes'
        ];
    } else {
        return [
            'status'     => 'Weak',
            'stageLabel' => 'Foundation',
            'actionType' => 'Focus on foundation-building and critical improvements'
        ];
    }
}
function calculateCategoryScores(array $answers, array $questions, string $language): array
{
    $categoryScores = [];

    if ($language === 'en') {
        // MOVE framework
        $categories = ['Market', 'Operations', 'Velocity', 'Expansion'];

        foreach ($categories as $category) {
            $categoryQuestions = array_filter(
                $questions,
                fn($q) => $q['category'] === $category
            );

            $scores = [];
            foreach ($categoryQuestions as $q) {
                if (isset($answers[$q['id']])) {
                    $scores[] = $answers[$q['id']];
                }
            }

            $key = strtolower($category);
            $categoryScores[$key] = count($scores)
                ? array_sum($scores) / count($scores)
                : 0;
        }

    } else {
        // 5W1H framework
        foreach ($questions as $q) {
            $key = strtolower($q['category']);
            $categoryScores[$key] = $answers[$q['id']] ?? 0;
        }
    }

    return $categoryScores;
}

function calculateOverallScore(array $categoryScores): float
{
    $scores = array_values($categoryScores);
    if (count($scores) === 0) return 0;

    $avg = array_sum($scores) / count($scores);

    return round($avg, 1); // same as JS: Math.round(x * 10) / 10
}

function getGrade(float $score): string
{
    foreach (GRADE_THRESHOLDS as $grade => $range) {
        if ($score >= $range['min'] && $score <= $range['max']) {
            return $grade;
        }
    }
    return 'D';
}

function getFeedbackLevel(float $score): string
{
    if ($score >= FEEDBACK_THRESHOLDS['STRONG']) {
        return 'STRONG';
    }

    if (
        $score >= FEEDBACK_THRESHOLDS['MODERATE_MIN'] &&
        $score <= FEEDBACK_THRESHOLDS['MODERATE_MAX']
    ) {
        return 'MODERATE';
    }

    return 'WEAK';
}

/* Category feedback uses same logic */
function getCategoryFeedbackLevel(float $score): string
{
    return getFeedbackLevel($score);
}

function processAssessment(array $answers, array $questions, string $language): array
{
    $categoryScores = calculateCategoryScores($answers, $questions, $language);
    $overallScore   = calculateOverallScore($categoryScores);
    $grade          = getGrade($overallScore);
    $feedbackLevel  = getFeedbackLevel($overallScore);

    return [
        'categoryScores' => $categoryScores,
        'overallScore'   => $overallScore,
        'grade'          => $grade,
        'feedbackLevel'  => $feedbackLevel,
    ];
}

function validateAnswers(array $answers, array $questions): bool
{
    foreach ($questions as $q) {
        if (
            !isset($answers[$q['id']]) ||
            $answers[$q['id']] < 1 ||
            $answers[$q['id']] > 10
        ) {
            return false;
        }
    }
    return true;
}
