<?php
require_once __DIR__ . '/../../config/helpers.php';

$assetBasePath = realpath(__DIR__ . '/../') ?: dirname(__DIR__);
$fontPath = rtrim($assetBasePath, '/') . '/';
$language = 'en';
$GLOBALS['langData'] = $langData ?? [];
$GLOBALS['gtmChallenges'] = $gtmChallenges ?? [];

function enAlphaAsset(string $path): string
{
    global $fontPath;
    return $fontPath . ltrim($path, '/');
}

function enAlphaImageDataUri(string $path): string
{
    $fullPath = enAlphaAsset($path);
    if (!is_file($fullPath)) {
        return $fullPath;
    }

    $extension = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));
    $mime = $extension === 'svg' ? 'image/svg+xml' : 'image/png';

    return 'data:' . $mime . ';base64,' . base64_encode((string) file_get_contents($fullPath));
}

function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function ___($key): string
{
    global $langData;
    return $langData['labels'][$key] ?? $key;
}

function enAlphaGrade(float $score): string
{
    if ($score >= 9.0) {
        return 'S';
    }
    if ($score >= 7.5) {
        return 'A';
    }
    if ($score >= 6.0) {
        return 'B';
    }
    if ($score >= 4.0) {
        return 'C';
    }
    return 'D';
}

function getGrade($score): string
{
    return enAlphaGrade((float) $score);
}

function enAlphaGradeColor(string $grade): string
{
    return [
        'S' => '#0c5395',
        'A' => '#6d98bf',
        'B' => '#0c956e',
        'C' => '#fbb800',
        'D' => '#767676',
    ][$grade] ?? '#767676';
}

function enAlphaGradeBandLabel(string $grade): string
{
    return [
        'S' => 'GTM Excellence',
        'A' => 'GTM Advanced',
        'B' => 'GTM Competent',
        'C' => 'GTM Developing',
        'D' => 'GTM Foundation',
    ][$grade] ?? 'GTM Foundation';
}

function enAlphaContent(float $score): array
{
    global $langData;

    $grade = enAlphaGrade($score);
    $raw = $langData['gradeContent'][$grade] ?? [];

    return [
        'grade' => $grade,
        'heading' => $raw['heading'] ?? enAlphaGradeBandLabel($grade),
        'description' => $raw['description'] ?? '',
    ];
}

function enAlphaWrap(string $text, int $lineLength): string
{
    $text = trim(preg_replace('/\s+/', ' ', $text) ?? '');
    if ($text === '') {
        return '';
    }

    $wrapped = wordwrap($text, $lineLength, "\n", false);
    $lines = array_filter(explode("\n", $wrapped), static fn ($line) => trim($line) !== '');

    return implode('<br>', array_map('e', $lines));
}

function enAlphaPdfTruncate(string $text, int $maxWidth): string
{
    $text = trim(preg_replace('/\s+/', ' ', $text) ?? '');
    if ($text === '') {
        return '';
    }

    if (mb_strwidth($text, 'UTF-8') <= $maxWidth) {
        return $text;
    }

    return rtrim(mb_strimwidth($text, 0, $maxWidth, '...', 'UTF-8'));
}

function enAlphaEvaluationTitle(string $grade, string $fallback): string
{
    $titles = [
        'S' => ['Industry-leading,', 'best-in-class performance'],
        'A' => ['Strong strategic execution,', 'competitive advantage'],
        'B' => ['Strong foundation,', 'ready to scale'],
        'C' => ['Clear improvement areas,', 'systematic approach needed'],
        'D' => ['Basic infrastructure', 'building required'],
    ];

    if (!isset($titles[$grade])) {
        return enAlphaWrap($fallback, 28);
    }

    return implode('<br>', array_map('e', $titles[$grade]));
}

function enAlphaWrappedLines(string $text, int $lineLength): array
{
    $text = trim(preg_replace('/\s+/', ' ', $text) ?? '');
    if ($text === '') {
        return [];
    }

    $wrapped = wordwrap($text, $lineLength, "\n", false);
    return array_values(array_filter(explode("\n", $wrapped), static fn ($line) => trim($line) !== ''));
}

function enAlphaEstimatedLineCount(string $text, int $lineLength): int
{
    return count(enAlphaWrappedLines($text, $lineLength));
}

function enAlphaPositionedTextLines(string $text, int $lineLength, float $lineHeight, string $className): string
{
    $html = '';
    foreach (enAlphaWrappedLines($text, $lineLength) as $index => $line) {
        $top = $index * $lineHeight;
        $html .= '<span class="' . e($className) . '" style="top:' . e(number_format($top, 1, '.', '')) . 'px;">' . e($line) . '</span>';
    }

    return $html;
}

function enAlphaNextGrade(string $grade): ?string
{
    $order = ['D', 'C', 'B', 'A', 'S'];
    $index = array_search($grade, $order, true);

    if ($index === false || $grade === 'S') {
        return null;
    }

    return $order[$index + 1] ?? null;
}

function enAlphaNextAction(string $revenueRange, string $grade): string
{
    global $langData;

    if (empty($langData['nextActions'][$revenueRange])) {
        return '';
    }

    if ($grade === 'S') {
        return $langData['nextActions'][$revenueRange]['S'] ?? '';
    }

    $nextGrade = enAlphaNextGrade($grade);
    if (!$nextGrade) {
        return '';
    }

    return $langData['nextActions'][$revenueRange][$grade . '_' . $nextGrade] ?? '';
}

function normalizeEnAlphaRevenueRange(string $revenueRange): string
{
    return [
        'smb' => 'smb',
        'mid-market' => 'mid-market',
        'enterprise' => 'enterprise',
    ][$revenueRange] ?? $revenueRange;
}

function enAlphaEvaluationText(string $revenueRange): string
{
    $texts = [
        'smb' => 'As an early-stage or small business, you are in the foundation-building phase of your GTM strategy. The priority is to maximize limited resources, clearly define your target customers, and establish a simple yet effective repeatable acquisition motion that sets the stage for sustainable growth.',
        'mid-market' => 'As a scaling organization, the key challenge is to standardize and streamline processes while strengthening cross-functional collaboration. Moving from founder-driven sales to structured, repeatable go-to-market operations will enable you to build a sustainable growth engine and improve overall efficiency.',
        'enterprise' => 'As a large enterprise, maintaining and enhancing competitive advantage requires an integrated GTM strategy across multiple business units and markets. Balancing optimization of existing operations with innovation and expansion into new business areas is essential to sustain leadership and drive long-term impact.',
    ];

    $normalizedRevenueRange = normalizeEnAlphaRevenueRange($revenueRange);

    return $texts[$normalizedRevenueRange] ?? $texts['smb'];
}

function enAlphaNextLead(string $revenueRange, string $grade): string
{
    $texts = [
        'smb' => [
            'D' => 'As a small business, you are still in the early stages of GTM. Building a clear target definition and simple value proposition is critical to avoid diluted efforts and establish a foundation for growth.',
            'C' => 'Basic roles and responsibilities across sales and marketing are emerging. The next step is to improve coordination and introduce simple KPI tracking to enable more consistent performance.',
            'B' => 'You have a relatively strong GTM base for your stage. Standardizing processes and introducing data-driven decision-making will create a repeatable growth model.',
            'A' => 'Reaching this stage as an SMB reflects strong execution and strategic discipline. With structured processes in place, you can accelerate expansion into new markets and channels by leveraging analytics and automation.',
            'S' => 'This level is uncommon at this stage and reflects exceptional GTM maturity. By institutionalizing GTM excellence and establishing a scalable model, you can secure market leadership even as a younger company.',
        ],
        'mid-market' => [
            'D' => 'As a scaling company, ad-hoc sales activities are no longer sustainable. Standardizing repeatable processes is essential to stabilize revenue growth.',
            'C' => 'Departmental expertise is improving, but lack of cross-functional alignment creates inefficiency. Unified KPIs and regular collaboration can unlock stronger growth.',
            'B' => 'Your GTM framework is maturing. Leveraging data analysis and expanding revenue from existing customers will help establish a sustainable growth engine.',
            'A' => 'A high level of maturity for mid-market companies. Comprehensive data management and segmentation enable efficient expansion and improved profitability.',
            'S' => 'At this level, you are operating at best-in-class maturity. With advanced GTM systems, you can expand into new business areas and partnerships, consolidating market leadership.',
        ],
        'enterprise' => [
            'D' => 'As a large enterprise, fragmented GTM activities reduce efficiency. Building an integrated strategy across business units is urgent to maximize scale advantages.',
            'C' => 'Functional expertise is strong, but silos persist. Strengthening cross-unit collaboration and introducing shared platforms are key to global competitiveness.',
            'B' => 'You have established a strong GTM foundation. Accelerating digital transformation and leveraging innovation will enhance market position and long-term resilience.',
            'A' => 'Very high execution capability. Advanced data integration and AI adoption enable portfolio optimization and strategic positioning in emerging markets.',
            'S' => 'You are operating at a highly advanced GTM level. You lead industry ecosystems, drive innovation, and shape next-generation business models with global impact.',
        ],
    ];

    $normalizedRevenueRange = normalizeEnAlphaRevenueRange($revenueRange);

    return $texts[$normalizedRevenueRange][$grade] ?? $texts['smb'][$grade] ?? $texts['smb']['D'];
}

function enAlphaNextLeadLineLength(string $grade): int
{
    return [
        'S' => 68,
        'A' => 72,
        'B' => 72,
        'C' => 66,
        'D' => 66,
    ][$grade] ?? 70;
}

function enAlphaSelectedChallengeLabels(array $gtmChallenges, array $selectedChallenges): array
{
    $labels = [];

    foreach ($selectedChallenges as $selectedChallenge) {
        $challengeKey = 'challenge' . (int) $selectedChallenge;
        if (isset($gtmChallenges[$challengeKey])) {
            $labels[] = (string) $gtmChallenges[$challengeKey];
        }
    }

    if (!$labels) {
        $labels = array_values($gtmChallenges);
    }

    return array_slice($labels, 0, 3);
}

function enAlphaFeedbackLevel(float $score): int
{
    return $score < 2 ? 1 : 2;
}

function enAlphaFeedbackText(string $category, float $score, ?int $levelOverride = null): string
{
    global $langData;

    $level = (string) ($levelOverride ?? enAlphaFeedbackLevel($score));
    return $langData['individualFeedback'][$category][$level]['text'] ?? '';
}

function enAlphaFeedbackRecommendation(string $category, float $score, string $revenueRange, ?int $levelOverride = null): string
{
    global $langData;

    $level = (string) ($levelOverride ?? enAlphaFeedbackLevel($score));
    return $langData['individualFeedback'][$category][$level]['recommendation'][$revenueRange] ?? '';
}

function enAlphaFeedbackCategories(array $categoryScores, array $fixedOrder, int $limit = 1, ?string $overrideCategory = null): array
{
    $eligible = [];

    foreach ($categoryScores as $category => $score) {
        $score = (float) $score;
        if ($score <= 2) {
            $eligible[(string) $category] = $score;
        }
    }

    if (!$eligible) {
        return [];
    }

    if ($overrideCategory !== null && $overrideCategory !== '') {
        foreach ($eligible as $category => $score) {
            if (strtolower((string) $category) === strtolower($overrideCategory)) {
                return [(string) $category => $score];
            }
        }
    }

    $positions = array_flip($fixedOrder);
    uksort($eligible, static function ($a, $b) use ($eligible, $positions) {
        $scoreComparison = $eligible[$a] <=> $eligible[$b];
        if ($scoreComparison !== 0) {
            return $scoreComparison;
        }

        $positionA = $positions[strtolower((string) $a)] ?? 999;
        $positionB = $positions[strtolower((string) $b)] ?? 999;
        if ($positionA !== $positionB) {
            return $positionA <=> $positionB;
        }

        return strcmp((string) $a, (string) $b);
    });

    return array_slice($eligible, 0, $limit, true);
}

function renderEnAlphaGradePills(string $activeGrade): string
{
    $x = 0;
    $html = '<span class="grade-pill-list">';

    foreach (['D', 'C', 'B', 'A', 'S'] as $grade) {
        $isActive = $grade === $activeGrade;
        $size = $isActive ? 36 : 20;
        $top = $isActive ? 0 : 8;
        $color = $isActive ? enAlphaGradeColor($grade) : '#9eadbc';
        $class = $isActive ? 'grade-pill is-active' : 'grade-pill';

        $html .= '<span class="' . $class . '" style="left:' . $x . 'px;top:' . $top . 'px;width:' . $size . 'px;height:' . $size . 'px;border-radius:' . $size . 'px;color:' . e($color) . ';"><span class="grade-pill-text">' . e($grade) . '</span></span>';
        $x += $size + 4;
    }

    return $html . '</span>';
}

function renderEnAlphaSidebar(): string
{
    return '<div class="alpha-sidebar-bleed"></div><div class="alpha-sidebar-frame"><img class="alpha-sidebar-image" src="' . e(enAlphaImageDataUri('images/alpha/sidebar-frame-2277-material.png')) . '" alt=""></div>';
}

function renderEnAlphaCategoryCard(string $category, float $score, int $index = 0, ?string $gradeOverride = null): string
{
    $grade = $gradeOverride ?: enAlphaGrade($score);
    $positionClass = 'cat-pos-' . max(0, min(3, $index));

    return '
        <div class="category-card ' . e($positionClass) . '">
            <div class="category-head"><p>' . e(ucfirst($category)) . '</p></div>
            <div class="category-body">
                <div class="cat-score">
                    <p class="cat-label">Score</p>
                    <p class="cat-score-value">' . e(number_format($score, 1)) . '</p>
                </div>
                <div class="cat-slash"><img class="cat-slash-img" src="' . e(enAlphaImageDataUri('images/alpha/figma/category-slash-1-2163-dompdf.png')) . '" alt=""></div>
                <div class="cat-grade">
                    <p class="cat-label">Grade</p>
                    <p class="cat-grade-value" style="color:' . e(enAlphaGradeColor($grade)) . ';">' . e($grade) . '</p>
                </div>
            </div>
        </div>
    ';
}

function renderEnAlphaNextStepVisual(string $grade): string
{
    $grade = in_array($grade, ['S', 'A', 'B', 'C', 'D'], true) ? $grade : 'D';
    $asset = $grade === 'S'
        ? 'images/alpha/en-next-step-S-material-flat.png'
        : 'images/alpha/next-step-' . $grade . '.svg';

    return '<img class="next-step-visual-img next-step-visual-img--' . e($grade) . '" src="' . e(enAlphaImageDataUri($asset)) . '" alt="">';
}

function renderEnAlphaFeedbackCard(string $category, float $score, string $revenueTag, string $revenueRange, ?int $levelOverride = null): string
{
    $level = $levelOverride ?? enAlphaFeedbackLevel($score);
    $text = enAlphaFeedbackText($category, $score, $level);
    $recommendation = enAlphaFeedbackRecommendation($category, $score, $revenueRange, $level);
    $stars = $level <= 1 ? 'images/alpha/fb/star-rating-1.png' : 'images/alpha/fb/star-rating-2.png';

    return '
        <div class="feedback-row-card">
            <div class="feedback-left">
                <div class="feedback-title-line">
                    <p class="feedback-category-title">' . e(ucfirst($category)) . '</p>
                    <img class="feedback-stars" src="' . e(enAlphaImageDataUri($stars)) . '" alt="">
                </div>
                <p class="feedback-copy">' . e($text) . '</p>
            </div>
            <div class="feedback-right">
                <p class="feedback-revenue">' . e($revenueTag) . '</p>
                <img class="feedback-arrow" src="' . e(enAlphaImageDataUri('images/alpha/fb/recommend-arrow.png')) . '" alt="">
                <p class="feedback-recommendation">' . e($recommendation) . '</p>
            </div>
        </div>
    ';
}

$score = (float) ($assessmentResult['overallScore'] ?? 0);
$assessmentGrade = (string) ($assessmentResult['grade'] ?? enAlphaGrade($score));
$displayGrade = (string) ($assessmentResult['displayGrade'] ?? $assessmentGrade);
$content = enAlphaContent($score);
$categoryOrder = ['market', 'operations', 'velocity', 'expansion'];
$categoryScores = $assessmentResult['categoryScores'] ?? [];
$categoryGrades = $assessmentResult['categoryGrades'] ?? [];
$selectedChallenges = $selectedChallenges ?? [];
$challengeLabels = enAlphaSelectedChallengeLabels($gtmChallenges ?? [], $selectedChallenges);

$user = $user ?? [];
$fullName = $fullName ?? ($user['name'] ?? trim(($user['firstName'] ?? '') . ' ' . ($user['lastName'] ?? '')));
$jobTitle = $job_title ?? ($user['job_title'] ?? '');
$departmentKey = $department ?? ($user['department'] ?? '');
$revenueRange = $revenue_range ?? ($user['revenue_range'] ?? '');

$jobTitleMap = [
    'staff' => 'Staff',
    'manager' => 'Manager',
    'director' => 'Director',
    'vp' => 'VP',
    'cxo' => 'CxO / Executive',
];

$departmentMap = [
    'sales' => 'Sales Department',
    'marketing' => 'Marketing Department',
    'business' => 'Business Development Department',
    'planning' => 'Corporate Planning Department',
    'other' => 'Other',
];

$revenueRangeMap = [
    'smb' => 'SMB (Small & Growing): Under $10M',
    'mid-market' => 'Mid-market (Scaling): $10M–$1B',
    'enterprise' => 'Enterprise (Global / Large-scale): Over $1B',
];

$revenueTagMap = [
    'smb' => 'SMB',
    'mid-market' => 'Mid',
    'enterprise' => 'Enterprise',
];

$jobTitleLabel = $jobTitleMap[$jobTitle] ?? (string) $jobTitle;
$departmentLabel = $departmentMap[$departmentKey] ?? (string) $departmentKey;
$revenueRangeLabel = $revenueRangeMap[$revenueRange] ?? (string) $revenueRange;
$revenueTag = $revenueTagMap[$revenueRange] ?? (string) $revenueRange;
$feedbackRevenueRange = $feedback_revenue_range ?? ($user['feedback_revenue_range'] ?? $revenueRange);
$feedbackRevenueTag = $revenueTagMap[$feedbackRevenueRange] ?? (string) $feedbackRevenueRange;
$feedbackCategoryOverride = isset($assessmentResult['feedbackCategoryOverride']) ? (string) $assessmentResult['feedbackCategoryOverride'] : null;
$feedbackLevelOverride = isset($assessmentResult['feedbackLevelOverride']) ? (int) $assessmentResult['feedbackLevelOverride'] : null;
$feedbackCategories = enAlphaFeedbackCategories($categoryScores, $categoryOrder, 1, $feedbackCategoryOverride);
$hasFeedback = !empty($feedbackCategories);
$nextStepGrade = $displayGrade;
$nextActionGrade = isset($assessmentResult['nextActionGradeOverride']) ? (string) $assessmentResult['nextActionGradeOverride'] : $nextStepGrade;
$nextActionText = enAlphaNextAction((string) $revenueRange, $nextActionGrade);
$nextActionLineCount = enAlphaEstimatedLineCount($nextActionText, 82);
$headerName = enAlphaPdfTruncate(trim((string) ($user['company'] ?? 'weblance info') . ' ' . ($fullName ?: 'First Name Last Name')), 40);
$pageClasses = ['alpha-page'];
if ($hasFeedback) {
    $pageClasses[] = 'has-feedback';
}
if ($hasFeedback && $nextActionLineCount >= 3) {
    $pageClasses[] = 'has-long-action';
}
$date = date('d/m/Y');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        @font-face {
            font-family: "Montserrat";
            src: url("<?= $fontPath; ?>fonts/Montserrat-Regular.ttf") format("truetype");
            font-weight: normal;
        }

        @font-face {
            font-family: "Montserrat";
            src: url("<?= $fontPath; ?>fonts/Montserrat-Medium.ttf") format("truetype");
            font-weight: 500;
        }

        @font-face {
            font-family: "Montserrat";
            src: url("<?= $fontPath; ?>fonts/Montserrat-Bold.ttf") format("truetype");
            font-weight: bold;
        }

        @page {
            size: A4;
            margin: 0;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            width: 595px;
            height: 842px;
            font-family: "Montserrat", sans-serif;
            color: #24394c;
            background: #ffffff;
        }

        p {
            margin: 0;
            padding: 0;
        }

        .alpha-page {
            position: relative;
            width: 595px;
            height: 842px;
            overflow: hidden;
            background: #ffffff;
            transform: scale(1.333333);
            transform-origin: 0 0;
        }

        .alpha-bg {
            position: absolute;
            top: 0;
            left: 60px;
            width: 535px;
            height: 842px;
            background-image: url("<?= $fontPath; ?>images/background.png");
            background-size: 535px 842px;
            background-position: center;
            background-repeat: no-repeat;
        }

        .alpha-sidebar-frame {
            position: absolute;
            left: 0;
            top: 0;
            width: 60px;
            height: 842px;
            overflow: hidden;
            z-index: 3;
        }

        .alpha-sidebar-bleed {
            position: absolute;
            left: 0;
            top: -1px;
            width: 60px;
            height: 844px;
            background: #3d75aa;
            z-index: 2;
        }

        .alpha-sidebar-image {
            display: block;
            position: absolute;
            left: 0;
            top: 0;
            width: 120px;
            height: 1684px;
            transform: scale(0.5);
            transform-origin: 0 0;
        }

        .alpha-content {
            position: absolute;
            top: 0;
            left: 60px;
            width: 535px;
            height: 842px;
            padding: 0;
        }

        .alpha-header {
            position: absolute;
            top: 12px;
            left: 16px;
            width: 503px;
            height: 50px;
            border-bottom: 1px solid #9eadbc;
            font-weight: bold;
        }

        .has-feedback .alpha-header {
            left: 16px;
            height: 50px;
        }

        .header-name {
            position: absolute;
            top: 0;
            left: 4px;
            width: 306px;
            font-size: 14px;
            line-height: 16px;
            color: #383838;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .header-date {
            position: absolute;
            top: 2px;
            right: 0;
            width: 160px;
            text-align: right;
            font-size: 8px;
            line-height: 10px;
            color: #4c4c4c;
            white-space: nowrap;
            z-index: 2;
        }

        .header-meta-line1,
        .header-meta-line2 {
            position: absolute;
            left: 4px;
            width: 492px;
            font-size: 10px;
            line-height: 12px;
            color: #4c4c4c;
            white-space: nowrap;
        }

        .header-meta-line1 {
            top: 17px;
        }

        .header-meta-line2 {
            top: 32px;
        }

        .header-name,
        .header-date,
        .header-meta-line1,
        .header-meta-line2,
        .section-title,
        .section-kicker,
        .overall-left-label,
        .overall-left-main,
        .score-label,
        .grade-label,
        .score-value,
        .grade-pill-text,
        .grade-band-text,
        .evaluation-title,
        .evaluation-text,
        .cat-label,
        .cat-score-value,
        .cat-grade-value,
        .next-lead,
        .challenge-heading span,
        .challenge-list li,
        .action-heading,
        .action-list li,
        .feedback-heading,
        .feedback-category-title,
        .feedback-copy,
        .feedback-revenue,
        .feedback-recommendation,
        .footer-copy {
            transform: translateY(-0.25em);
            transform-origin: left top;
        }

        .section-heading {
            position: absolute;
            top: 86px;
            left: 16px;
            width: 503px;
            height: 16px;
            font-weight: bold;
        }

        .has-feedback .section-heading {
            top: 78px;
            left: 16px;
        }

        .section-title {
            position: absolute;
            top: 0;
            left: 4px;
            font-size: 16px;
            line-height: 16px;
            color: #24394c;
        }

        .section-kicker {
            position: absolute;
            top: 1px;
            right: 4px;
            font-size: 12px;
            line-height: 14px;
            color: #cacaca;
        }

        .overall {
            position: absolute;
            top: 110px;
            left: 16px;
            width: 503px;
            height: 260px;
            border: 1px solid #3d75aa;
            border-radius: 4px;
            overflow: hidden;
            background: #ffffff;
        }

        .has-feedback .overall {
            top: 103px;
            left: 16px;
            height: 240px;
        }

        .overall-left {
            position: absolute;
            top: 0;
            left: 0;
            width: 168.35px;
            height: 260px;
            background: #3d75aa;
            text-align: center;
            color: #ffffff;
            font-weight: bold;
        }

        .has-feedback .overall-left {
            height: 240px;
        }

        .overall-icon {
            position: absolute;
            top: 47px;
            left: 68px;
            width: 32px;
            height: 32px;
        }

        .has-feedback .overall-icon {
            top: 48px;
        }

        .overall-left-label {
            position: absolute;
            top: 116px;
            left: 14px;
            width: 140px;
            font-size: 12px;
            line-height: 14px;
        }

        .overall-left-label:before,
        .overall-left-label:after {
            content: "";
            position: absolute;
            top: 7px;
            width: 16px;
            border-top: 1px solid #ffffff;
        }

        .overall-left-label:before {
            left: 0;
        }

        .overall-left-label:after {
            right: 0;
        }

        .overall-left-main {
            position: absolute;
            top: 139px;
            left: 14px;
            width: 140px;
            font-size: 20px;
            line-height: 22px;
        }

        .has-feedback .overall-left-label {
            top: 113px;
        }

        .has-feedback .overall-left-main {
            top: 136px;
        }

        .overall-right {
            position: absolute;
            top: 0;
            left: 168.35px;
            width: 334.65px;
            height: 260px;
            background: #f4faff;
            font-weight: bold;
        }

        .has-feedback .overall-right {
            height: 240px;
        }

        .score-grade-row {
            position: absolute;
            top: 20px;
            left: 12px;
            width: 310px;
            height: 72px;
        }

        .has-feedback .score-grade-row {
            top: 10px;
        }

        .score-box,
        .grade-box {
            position: absolute;
            top: 0;
            height: 68px;
            text-align: center;
        }

        .score-box {
            left: 31px;
            width: 80px;
        }

        .grade-box {
            left: 148px;
            width: 132px;
        }

        .score-label,
        .grade-label {
            font-size: 12px;
            line-height: 12px;
            color: #24394c;
        }

        .score-value {
            margin-top: -3px;
            font-size: 36px;
            line-height: 36px;
            color: #3d75aa;
        }

        .overall-slash {
            position: absolute;
            top: 2px;
            left: 119px;
            width: 24px;
            height: 56px;
        }

        .overall-slash-img {
            display: block;
            width: 24px;
            height: 56px;
        }

        .grade-pill-list {
            position: relative;
            display: block;
            width: 132px;
            height: 36px;
            margin-top: 1px;
        }

        .grade-pill {
            position: absolute;
            display: block;
            background: #ffffff;
            text-align: center;
        }

        .grade-pill-text {
            display: block;
            position: relative;
            top: -4px;
            width: 100%;
            font-size: 10px;
            line-height: 20px;
            font-weight: bold;
        }

        .grade-pill.is-active .grade-pill-text {
            top: -8px;
            font-size: 24px;
            line-height: 36px;
        }

        .grade-band {
            position: absolute;
            top: 80px;
            left: 12px;
            width: 310px;
            height: 24px;
            border-radius: 60px;
            background: #3d75aa;
            text-align: center;
            color: #ffffff;
        }

        .has-feedback .grade-band {
            top: 72px;
        }

        .grade-band-text {
            display: block;
            position: relative;
            top: -5px;
            font-size: 12px;
            line-height: 24px;
        }

        .has-feedback .grade-band-text {
            top: -5px;
        }

        .evaluation {
            position: absolute;
            top: 100px;
            left: 12px;
            width: 310px;
            text-align: center;
        }

        .has-feedback .evaluation {
            top: 100px;
        }

        .has-feedback .evaluation-title-row {
            min-height: 38px;
        }

        .has-feedback .evaluation-title {
            top: 2px;
            max-width: 286px;
            font-size: 16px;
            line-height: 15px;
        }

        .has-feedback .evaluation-title-row:before,
        .has-feedback .evaluation-title-row:after {
            top: 16px;
        }

        .has-feedback .evaluation-text {
            margin-top: 0;
            font-size: 8px;
            line-height: 10.8px;
        }

        .evaluation-title-row {
            position: relative;
            width: 310px;
            min-height: 38px;
        }

        .evaluation-title {
            position: relative;
            display: inline-block;
            top: 13px;
            max-width: 286px;
            font-size: 16px;
            line-height: 15px;
            color: #3d75aa;
            text-align: center;
            white-space: nowrap;
        }

        .evaluation-title-row:before,
        .evaluation-title-row:after {
            content: "";
            position: absolute;
            top: 32px;
            width: 33px;
            border-top: 1px solid #3d75aa;
        }

        .evaluation-title-row:before {
            left: 0;
        }

        .evaluation-title-row:after {
            right: 0;
        }

        .evaluation-text {
            margin-top: 16px;
            font-size: 9px;
            line-height: 11px;
            color: #4c4c4c;
            text-align: left;
        }

        .category-grid {
            position: absolute;
            top: 396px;
            left: 16px;
            width: 503px;
            height: 64px;
        }

        .has-feedback .category-grid {
            top: 360px;
            left: 16px;
            height: 64px;
        }

        .has-feedback .category-card {
            position: relative;
            float: left;
            width: 117.75px;
            height: 62px;
            margin-right: 8px;
        }

        .has-feedback .category-card.cat-pos-0 {
            left: auto;
            top: auto;
        }

        .has-feedback .category-card.cat-pos-1 {
            left: auto;
            top: auto;
        }

        .has-feedback .category-card.cat-pos-2 {
            left: auto;
            top: auto;
        }

        .has-feedback .category-card.cat-pos-3 {
            left: auto;
            top: auto;
            margin-right: 0;
        }

        .has-feedback .cat-score {
            top: -1px;
            left: 16px;
        }

        .has-feedback .cat-grade {
            top: -1px;
            right: 16px;
        }

        .has-feedback .cat-slash {
            top: 1px;
            left: 58px;
        }

        .category-card {
            float: left;
            width: 117.75px;
            height: 62px;
            margin-right: 8px;
            border: 1px solid #3d75aa;
            border-radius: 4px;
            overflow: hidden;
            background: #f4faff;
            font-weight: bold;
        }

        .category-card:last-child {
            margin-right: 0;
        }

        .category-head {
            height: 24px;
            background: #6d98bf;
            color: #ffffff;
            text-align: center;
        }

        .category-head p {
            position: relative;
            top: -9px;
            margin: 0;
            font-size: 12px;
            line-height: 24px;
        }

        .category-body {
            position: relative;
            height: 38px;
        }

        .cat-score {
            position: absolute;
            top: -4px;
            left: 14px;
            width: 36px;
            text-align: center;
        }

        .cat-grade {
            position: absolute;
            top: -4px;
            right: 14px;
            width: 30px;
            text-align: center;
        }

        .cat-label {
            position: relative;
            top: 8px;
            font-size: 8px;
            line-height: 8px;
            color: #24394c;
        }

        .cat-score-value,
        .cat-grade-value {
            font-size: 24px;
            line-height: 26px;
            color: #0c5395;
        }

        .cat-slash {
            position: absolute;
            top: 2px;
            left: 55px;
            width: 14px;
            height: 28px;
        }

        .cat-slash-img {
            display: block;
            width: 14px;
            height: 28px;
        }

        .next-panel {
            position: absolute;
            top: 484px;
            left: 16px;
            width: 503px;
            height: 250px;
            border: 0;
            border-radius: 4px;
            overflow: hidden;
            background: transparent;
        }

        .has-feedback .next-panel {
            top: 440px;
            left: 16px;
            height: 228px;
        }

        .next-title {
            position: absolute;
            top: 0;
            left: 0;
            width: 503px;
            height: 26px;
            padding-top: 5px;
            box-sizing: border-box;
            background: #0e3d68;
            color: #ffffff;
            text-align: center;
            font-size: 12px;
            line-height: 12px;
            font-weight: bold;
            border-radius: 4px 4px 0 0;
            transform: none;
        }

        .next-body {
            position: absolute;
            left: 0;
            top: 26px;
            width: 501px;
            height: 223px;
            padding: 0;
            box-sizing: content-box;
            border: 1px solid #0e3d68;
            border-top: 0;
            border-radius: 0 0 4px 4px;
            overflow: hidden;
            background: #f4faff;
            font-weight: bold;
        }

        .next-watermark {
            position: absolute;
            left: 116px;
            top: 199px;
            width: 374px;
            height: 19px;
            opacity: 1;
            z-index: 1;
        }

        .next-figure {
            position: absolute;
            left: 416.7px;
            top: 133px;
            width: 71px;
            height: 71px;
        }

        .has-feedback .next-body {
            height: 201px;
        }

        .has-feedback .next-watermark {
            top: 175px;
        }

        .has-feedback .next-figure {
            top: 111px;
        }

        .next-top {
            position: absolute;
            top: 12px;
            left: 12px;
            width: 479px;
            height: 49px;
        }

        .next-step-visual-img {
            position: absolute;
            left: 0;
            display: block;
            margin: 0;
        }

        .next-step-visual-img--S {
            top: 0;
            width: 114px;
            height: 49px;
        }

        .next-step-visual-img--A,
        .next-step-visual-img--B,
        .next-step-visual-img--C,
        .next-step-visual-img--D {
            top: 5px;
            width: 116px;
            height: 41px;
        }

        .next-lead {
            position: absolute;
            top: 3.5px;
            left: 127px;
            width: 352px;
            height: 42px;
            font-size: 9px;
            line-height: 14px;
            color: #0e3d68;
            font-weight: 500;
            overflow: hidden;
            transform: none;
        }

        .next-lead-line {
            position: absolute;
            left: 0;
            display: block;
            width: 352px;
            height: 14px;
            line-height: 14px;
            white-space: nowrap;
            transform: translateY(-0.12em);
            transform-origin: left top;
        }

        .challenge-heading {
            position: absolute;
            top: 73px;
            left: 12px;
            margin: 0;
            width: 479px;
            height: 12px;
            color: #0e3d68;
        }

        .challenge-heading span {
            position: absolute;
            top: 0;
            left: 0;
            display: block;
            font-size: 12px;
            line-height: 12px;
            white-space: nowrap;
        }

        .challenge-heading:after {
            content: "";
            position: absolute;
            top: 6px;
            right: 0;
            width: 200px;
            border-top: 1px solid #9eadbc;
        }

        .challenge-list {
            position: absolute;
            top: 94px;
            left: 12px;
            margin: 0;
            padding: 0;
            list-style: none;
            width: 479px;
            z-index: 2;
        }

        .challenge-list li {
            position: relative;
            height: 12px;
            margin: 0 0 4px;
            padding: 0 0 0 16px;
            font-size: 8px;
            line-height: 8px;
            color: #0e3d68;
            white-space: nowrap;
        }

        .challenge-list img {
            position: absolute;
            top: 0;
            left: 0;
            width: 12px;
            height: 12px;
        }

        .action-heading {
            position: absolute;
            top: 147px;
            left: 12px;
            margin: 0;
            width: 399px;
            color: #d85f08;
            font-size: 12px;
            line-height: 12px;
            font-weight: bold;
        }

        .action-list {
            position: absolute;
            top: 157px;
            left: 12px;
            width: 399px;
            height: 48px;
            margin: 0;
            padding: 0;
            list-style: none;
            z-index: 2;
        }

        .action-list li {
            position: relative;
            width: 381px;
            height: 48px;
            padding: 0 0 0 18px;
            color: #0e3d68;
            font-size: 9px;
            line-height: 16px;
            overflow: hidden;
            transform: none;
        }

        .action-list img {
            position: absolute;
            top: 4px;
            left: 2px;
            width: 12px;
            height: 16px;
        }

        .action-line {
            position: absolute;
            left: 18px;
            display: block;
            width: 381px;
            height: 16px;
            font-size: 8.5px;
            line-height: 16px;
            white-space: nowrap;
            transform: translateY(-0.12em);
            transform-origin: left top;
        }

        .has-feedback.has-long-action .next-panel {
            height: 254px;
        }

        .has-feedback.has-long-action .next-body {
            height: 227px;
        }

        .has-feedback.has-long-action .next-watermark {
            top: 201px;
        }

        .has-feedback.has-long-action .next-figure {
            top: 137px;
        }

        .has-feedback.has-long-action .action-list,
        .has-feedback.has-long-action .action-list li {
            height: 64px;
        }

        .feedback-panel {
            position: absolute;
            top: 678px;
            left: 16px;
            width: 503px;
            height: 62px;
        }

        .has-feedback .feedback-panel {
            top: 690px;
            left: 16px;
            height: 76px;
        }

        .has-feedback.has-long-action .feedback-panel {
            top: 704px;
        }

        .feedback-heading {
            position: absolute;
            top: 4px;
            left: 4px;
            color: #24394c;
            font-size: 9px;
            line-height: 10px;
            font-weight: bold;
        }

        .feedback-row-card {
            position: absolute;
            top: 17px;
            left: 0;
            width: 503px;
            height: 55px;
            background: #f2f2f2;
            font-weight: bold;
        }

        .feedback-left {
            position: absolute;
            top: 4px;
            left: 8px;
            width: 263px;
            height: 47px;
        }

        .feedback-title-line {
            position: relative;
            width: 263px;
            height: 10px;
        }

        .feedback-category-title {
            position: absolute;
            top: 0;
            left: 0;
            color: #d52154;
            font-size: 8px;
            line-height: 8px;
        }

        .feedback-stars {
            position: absolute;
            top: 0;
            right: 0;
            width: 40px;
            height: 8px;
        }

        .feedback-copy {
            margin-top: 4px;
            color: #4c4c4c;
            font-size: 6.7px;
            line-height: 10px;
        }

        .feedback-right {
            position: absolute;
            top: 4px;
            right: 8px;
            width: 216px;
            height: 47px;
            background: #ffffff;
        }

        .feedback-revenue {
            position: absolute;
            left: 8px;
            top: 13px;
            width: 42px;
            color: #d52154;
            font-size: 6px;
            line-height: 6px;
            text-align: center;
        }

        .feedback-arrow {
            position: absolute;
            left: 52px;
            top: 9px;
            width: 10px;
            height: 18px;
        }

        .feedback-recommendation {
            position: absolute;
            left: 70px;
            top: 7px;
            width: 138px;
            color: #4c4c4c;
            font-size: 5.8px;
            line-height: 9px;
            font-weight: 600;
        }

        .alpha-footer {
            position: absolute;
            left: 16px;
            top: 781px;
            width: 503px;
            height: 45px;
            border-top: 1px solid #9eadbc;
            font-weight: 500;
        }

        .has-feedback .alpha-footer {
            left: 16px;
            top: 781px;
            bottom: auto;
            height: 45px;
        }

        .footer-copy {
            position: absolute;
            left: 0;
            top: 10px;
            width: 310px;
            color: #383838;
            font-size: 8px;
            line-height: 12px;
        }

        .has-feedback .footer-copy {
            left: 0;
            width: 310px;
            line-height: 12px;
        }

        .footer-brand {
            position: absolute;
            right: 0;
            top: 8px;
            width: 167px;
            height: 36px;
        }

        .has-feedback .footer-brand {
            right: 0;
            top: 8px;
        }

        .footer-brand-image {
            display: block;
            width: 167px;
            height: 36px;
        }
    </style>
</head>
<body>
<div class="<?= e(implode(' ', $pageClasses)) ?>">
    <div class="alpha-bg"></div>
    <?= renderEnAlphaSidebar() ?>

    <div class="alpha-content">
        <div class="alpha-header">
            <p class="header-name"><?= e($headerName) ?></p>
            <p class="header-date">Report Generated&nbsp;&nbsp;<?= e($date) ?></p>
            <p class="header-meta-line1">[Job] <?= e($jobTitleLabel) ?> &nbsp;/&nbsp; [Department] <?= e($departmentLabel) ?></p>
            <p class="header-meta-line2">[Revenue] <?= e($revenueRangeLabel) ?></p>
        </div>

        <div class="section-heading">
            <p class="section-title">GTM Maturity</p>
            <p class="section-kicker">GTM Maturity Assessment by Grade</p>
        </div>

        <div class="overall">
            <div class="overall-left">
                <img class="overall-icon" src="<?= e(enAlphaImageDataUri('images/alpha/score-icon-flat.png')) ?>" alt="">
                <p class="overall-left-label">GTM Maturity</p>
                <p class="overall-left-main">Overall Score</p>
            </div>
            <div class="overall-right">
                <div class="score-grade-row">
                    <div class="score-box">
                        <p class="score-label">Score</p>
                        <p class="score-value"><?= e(number_format($score, 1)) ?></p>
                    </div>
                    <div class="overall-slash"><img class="overall-slash-img" src="<?= e(enAlphaImageDataUri('images/alpha/figma/overall-slash-1-2390.svg')) ?>" alt=""></div>
                    <div class="grade-box">
                        <p class="grade-label">Grade</p>
                <?= renderEnAlphaGradePills($displayGrade) ?>
                    </div>
                </div>
                <div class="grade-band"><span class="grade-band-text"><?= e(enAlphaGradeBandLabel($assessmentGrade)) ?></span></div>
                <div class="evaluation">
                    <div class="evaluation-title-row">
                        <p class="evaluation-title"><?= enAlphaEvaluationTitle($assessmentGrade, (string) $content['description']) ?></p>
                    </div>
                    <p class="evaluation-text"><?= e(enAlphaEvaluationText((string) $revenueRange)) ?></p>
                </div>
            </div>
        </div>

        <div class="category-grid">
            <?php foreach ($categoryOrder as $index => $category): ?>
                <?= renderEnAlphaCategoryCard($category, (float) ($categoryScores[$category] ?? 0), (int) $index, isset($categoryGrades[$category]) ? (string) $categoryGrades[$category] : null) ?>
            <?php endforeach; ?>
        </div>

        <div class="next-panel">
            <p class="next-title">Next Steps</p>
            <div class="next-body">
                <img class="next-watermark" src="<?= e(enAlphaImageDataUri('images/alpha/report-watermark-material.png')) ?>" alt="">
                <div class="next-top">
                    <?= renderEnAlphaNextStepVisual($nextStepGrade) ?>
                    <p class="next-lead"><?= enAlphaPositionedTextLines(enAlphaNextLead((string) $revenueRange, $displayGrade), enAlphaNextLeadLineLength($displayGrade), 14, 'next-lead-line') ?></p>
                </div>
                <div class="challenge-heading"><span>GTM Challenges: Top 3 Priority Challenges</span></div>
                <ul class="challenge-list">
                    <?php foreach ($challengeLabels as $label): ?>
                        <li><img src="<?= e(enAlphaImageDataUri('images/alpha/clipboard-check.svg')) ?>" alt=""><?= e($label) ?></li>
                    <?php endforeach; ?>
                </ul>
                <p class="action-heading">Next Actions</p>
                <?php if ($nextActionText !== ''): ?>
                    <ul class="action-list">
                        <li><img src="<?= e(enAlphaImageDataUri('images/alpha/information.svg')) ?>" alt=""><?= enAlphaPositionedTextLines($nextActionText, 82, 16, 'action-line') ?></li>
                    </ul>
                <?php endif; ?>
                <img class="next-figure" src="<?= e(enAlphaImageDataUri('images/alpha/next-figure-material.png')) ?>" alt="">
            </div>
        </div>

        <?php if ($hasFeedback): ?>
            <div class="feedback-panel">
                <p class="feedback-heading">Individual Feedback</p>
                <?php foreach ($feedbackCategories as $category => $categoryScore): ?>
                    <?= renderEnAlphaFeedbackCard((string) $category, (float) $categoryScore, $feedbackRevenueTag, (string) $feedbackRevenueRange, $feedbackLevelOverride) ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="alpha-footer">
            <p class="footer-copy">Go-to-Market strategy starts with building repeatable revenue growth. Let&rsquo;s define what to sell, to whom, and how to win.</p>
            <div class="footer-brand">
                <img class="footer-brand-image" src="<?= e(enAlphaImageDataUri('images/alpha/footer-brand-frame-2657-pdf.png')) ?>" alt="GO-TO-MARKET STRATEGY QR">
            </div>
        </div>
    </div>
</div>
</body>
</html>
