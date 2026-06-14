<?php
require '../config/helpers.php';

$assetBasePath = realpath(__DIR__ . '/../') ?: dirname(__DIR__);
$fontPath = rtrim($assetBasePath, '/') . '/';
$language = 'ja';
$GLOBALS['langData'] = $langData ?? [];
$GLOBALS['gtmChallenges'] = $gtmChallenges ?? [];

function alphaAsset(string $path): string
{
    global $fontPath;
    return $fontPath . ltrim($path, '/');
}

function alphaImageDataUri(string $path): string
{
    $fullPath = alphaAsset($path);
    if (!is_file($fullPath)) {
        return $fullPath;
    }

    $extension = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));
    $mime = $extension === 'svg' ? 'image/svg+xml' : 'image/png';

    return 'data:' . $mime . ';base64,' . base64_encode((string) file_get_contents($fullPath));
}

function alphaTextLines(string $text, int $lineLength): string
{
    $text = trim($text);
    if ($text === '') {
        return '';
    }

    $lines = [];
    $length = mb_strlen($text, 'UTF-8');
    for ($offset = 0; $offset < $length; $offset += $lineLength) {
        $lines[] = e(mb_substr($text, $offset, $lineLength, 'UTF-8'));
    }

    return implode('<br>', $lines);
}

function alphaPositionedTextLines(string $text, int $lineLength, int $lineHeight): string
{
    $text = trim($text);
    if ($text === '') {
        return '';
    }

    $lines = [];
    $length = mb_strlen($text, 'UTF-8');
    for ($offset = 0; $offset < $length; $offset += $lineLength) {
        $lines[] = mb_substr($text, $offset, $lineLength, 'UTF-8');
    }

    $html = '';
    foreach ($lines as $index => $line) {
        $html .= '<span class="next-lead-line" style="top:' . ($index * $lineHeight) . 'px;">' . e($line) . '</span>';
    }

    return $html;
}

function alphaPdfTruncate(string $text, int $maxWidth): string
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

function e($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function ___($key)
{
    global $langData;
    return $langData['labels'][$key] ?? $key;
}

function getGrade($score)
{
    $thresholds = [
        'S' => ['min' => 9.0, 'max' => 10.0],
        'A' => ['min' => 7.5, 'max' => 8.9],
        'B' => ['min' => 6.0, 'max' => 7.4],
        'C' => ['min' => 4.0, 'max' => 5.9],
        'D' => ['min' => 1.0, 'max' => 3.9],
    ];

    foreach ($thresholds as $grade => $range) {
        if ($score >= $range['min'] && $score <= $range['max']) {
            return $grade;
        }
    }

    return 'D';
}

function getGtmScoreContent(float $score): array
{
    global $langData;

    $grade = getGrade($score);
    $raw = $langData['gradeContent'][$grade] ?? [];

    return [
        'grade' => $grade,
        'heading' => $raw['heading'] ?? '',
        'description' => $raw['description'] ?? '',
    ];
}

function getNextGrade(string $grade): ?string
{
    $order = ['D', 'C', 'B', 'A', 'S'];
    $index = array_search($grade, $order, true);

    if ($index === false || $grade === 'S') {
        return null;
    }

    return $order[$index + 1] ?? null;
}

function getNextAction($revenueRange, $grade)
{
    global $langData;

    $grade = strtoupper(trim((string) $grade));
    $revenueRange = trim((string) $revenueRange);

    if ($grade === 'S') {
        return $langData['nextAction'][$revenueRange]['S'] ?? null;
    }

    $nextGrade = getNextGrade($grade);
    if (!$nextGrade) {
        return null;
    }

    $key = $grade . '_to_' . $nextGrade;
    return $langData['nextAction'][$revenueRange][$key] ?? null;
}

function getAlphaGradeColor(string $grade): string
{
    return [
        'S' => '#0c5395',
        'A' => '#3d75aa',
        'B' => '#0c956e',
        'C' => '#fbb800',
        'D' => '#767676',
    ][$grade] ?? '#767676';
}

function getAlphaGradeBandLabel(string $grade): string
{
    return [
        'S' => 'GTM Excellence',
        'A' => 'GTM Advanced',
        'B' => 'GTM Competent',
        'C' => 'GTM Developing',
        'D' => 'GTM Foundation',
    ][$grade] ?? 'GTM Foundation';
}

function getAlphaCategoryGradeColor(string $grade): string
{
    return [
        'S' => '#0c5395',
        'A' => '#6d98bf',
        'B' => '#0c956e',
        'C' => '#fbb800',
        'D' => '#767676',
    ][$grade] ?? '#767676';
}

function renderAlphaGradePills(string $activeGrade): string
{
    $x = 0;
    $html = '<span class="grade-pill-list">';
    foreach (['D', 'C', 'B', 'A', 'S'] as $grade) {
        $isActive = $grade === $activeGrade;
        $size = $isActive ? 36 : 20;
        $top = $isActive ? 0 : 8;
        $class = $isActive ? 'grade-pill is-active' : 'grade-pill';
        $color = $isActive ? getAlphaGradeColor($grade) : '#9eadbc';
        $style = ' style="left:' . $x . 'px;top:' . $top . 'px;width:' . $size . 'px;height:' . $size . 'px;border-radius:' . $size . 'px;color:' . $color . ';"';
        $html .= '<span class="' . $class . '"' . $style . '><span class="grade-pill-text">' . e($grade) . '</span></span>';
        $x += $size + 4;
    }

    return $html . '</span>';
}

function renderAlphaSidebar(): string
{
    return '<div class="alpha-sidebar-bleed"></div><div class="alpha-sidebar-frame"><img class="alpha-sidebar-image" src="' . e(alphaImageDataUri('images/alpha/sidebar-frame-2277-material.png')) . '" alt=""></div>';
}

function renderAlphaCategoryCard(string $cat, array $labels, float $score, int $positionIndex): string
{
    $grade = getGrade($score);
    $classes = 'category-card cat-pos-' . $positionIndex;

    return '
        <div class="' . e($classes) . '">
            <div class="category-head">
                <p class="category-main">' . e($labels[0]) . '</p>
                <p class="category-sub">' . e($labels[1]) . '</p>
            </div>
            <div class="category-body">
                <div class="cat-score">
                    <p class="cat-label">スコア</p>
                    <p class="cat-score-value">' . e(number_format($score, 1)) . '</p>
                </div>
                <div class="cat-slash"><span></span></div>
                <div class="cat-grade">
                    <p class="cat-label">グレード</p>
                    <p class="cat-grade-value" style="color:' . e(getAlphaCategoryGradeColor($grade)) . ';">' . e($grade) . '</p>
                </div>
            </div>
        </div>
    ';
}

function getAlphaFeedbackStar(float $score): int
{
    return $score < 2 ? 1 : 2;
}

function getAlphaFeedbackContentLevel(float $score): int
{
    return $score < 2 ? 1 : 2;
}

function renderAlphaFeedbackStars(float $score): string
{
    $filled = getAlphaFeedbackStar($score);
    $asset = $filled <= 1 ? 'images/alpha/fb/star-rating-1.png' : 'images/alpha/fb/star-rating-2.png';

    return '<img class="feedback-stars" src="' . e(alphaImageDataUri($asset)) . '" alt="">';
}

function getAlphaFeedbackText(string $category, float $score): string
{
    global $langData;

    $star = (string) getAlphaFeedbackContentLevel($score);
    return $langData['individualFeedback'][$category][$star]['text'] ?? '';
}

function getAlphaFeedbackRecommendation(string $category, float $score, string $revenueRange): string
{
    global $langData;

    $star = (string) getAlphaFeedbackContentLevel($score);
    return $langData['individualFeedback'][$category][$star]['recommendation'][$revenueRange] ?? '';
}

function selectAlphaFeedbackCategories(array $categoryScores, array $fixedOrder, int $limit = 1, ?string $overrideCategory = null): array
{
    $eligibleCategories = [];

    foreach ($categoryScores as $cat => $score) {
        $score = (float) $score;
        if ($score <= 2) {
            $eligibleCategories[(string) $cat] = $score;
        }
    }

    if (!$eligibleCategories) {
        return [];
    }

    if ($overrideCategory !== null && $overrideCategory !== '') {
        foreach ($eligibleCategories as $cat => $score) {
            if (strtolower((string) $cat) === strtolower($overrideCategory)) {
                return [(string) $cat => $score];
            }
        }
    }

    $fixedOrderPositions = array_flip($fixedOrder);

    uksort($eligibleCategories, function ($a, $b) use ($eligibleCategories, $fixedOrderPositions) {
        $scoreComparison = $eligibleCategories[$a] <=> $eligibleCategories[$b];
        if ($scoreComparison !== 0) {
            return $scoreComparison;
        }

        $positionA = $fixedOrderPositions[strtolower((string) $a)] ?? 999;
        $positionB = $fixedOrderPositions[strtolower((string) $b)] ?? 999;
        if ($positionA !== $positionB) {
            return $positionA <=> $positionB;
        }

        return strcmp((string) $a, (string) $b);
    });

    return array_slice($eligibleCategories, 0, $limit, true);
}

function renderAlphaFeedbackCard(string $cat, array $labels, float $score, string $revenueRangeLabel, string $revenueRange): string
{
    $title = strtoupper($labels[0]) . '（' . $labels[1] . '）';
    $feedback = getAlphaFeedbackText($cat, $score);
    $recommendation = getAlphaFeedbackRecommendation($cat, $score, $revenueRange);

    return '
        <div class="feedback-row-card">
            <div class="feedback-left">
                <div class="feedback-title-line">
                    <p class="feedback-category-title">' . e($title) . '</p>
                    ' . renderAlphaFeedbackStars($score) . '
                </div>
                <p class="feedback-copy">' . alphaTextLines($feedback, 40) . '</p>
            </div>
            <div class="feedback-right">
                <p class="feedback-revenue">' . e($revenueRangeLabel) . '</p>
                <img class="feedback-arrow" src="' . e(alphaImageDataUri('images/alpha/fb/recommend-arrow.png')) . '" alt="">
                <p class="feedback-recommendation">' . alphaTextLines($recommendation, 20) . '</p>
            </div>
        </div>
    ';
}

function renderAlphaRuledTitle(string $text): string
{
    return '
        <table class="ruled-title" cellspacing="0" cellpadding="0">
            <tr>
                <td class="ruled-title-line"><span></span></td>
                <td class="ruled-title-text">' . e($text) . '</td>
                <td class="ruled-title-line"><span></span></td>
            </tr>
        </table>
    ';
}

function renderAlphaNextStep(string $currentGrade): string
{
    $grade = in_array($currentGrade, ['S', 'A', 'B', 'C', 'D'], true) ? $currentGrade : 'D';
    return '<img class="next-step-grade-img next-step-grade-img--' . e($grade) . '" src="' . e(alphaImageDataUri('images/alpha/next-step-' . $grade . '-material-flat.png')) . '" alt="">';
}

function getSelectedChallengeLabels(array $gtmChallenges, array $selectedChallenges): array
{
    $labels = [];

    foreach ($selectedChallenges as $selectedChallenge) {
        $challengeKey = 'challenge' . (int) $selectedChallenge;
        if (isset($gtmChallenges[$challengeKey])) {
            $labels[] = $gtmChallenges[$challengeKey];
        }
    }

    if (!$labels) {
        $labels = array_values($gtmChallenges);
    }

    return array_slice($labels, 0, 3);
}

function normalizeAlphaRevenueRange(string $revenueRange): string
{
    return [
        'smb' => 'under-1b',
        'mid-market' => '1b-5b',
        'enterprise' => 'over-10b',
    ][$revenueRange] ?? $revenueRange;
}

function alphaEvaluationText(string $revenueRange): string
{
    $texts = [
        'under-100m' => '創業期における基盤構築フェーズとして、GTM戦略の土台作りが重要な段階です。限られたリソースを最大活用し、効率的な顧客獲得メカニズムの確立が次の成長ステージへのカギとなります。',
        'under-1b' => '成長期企業として、組織拡大に伴うプロセス標準化と仕組み化が求められています。属人的な営業から組織的な営業への転換により、持続可能な成長基盤を構築できる段階です。',
        '1b-5b' => '事業拡大期において、複数事業・チャネルの統合的なGTM戦略が重要になっています。データドリブンな意思決定体制を強化することで、更なる市場シェア拡大が期待できます。',
        '5b-10b' => '成熟企業として、市場における競争優位性の維持・強化が重要な課題です。既存事業の最適化と新規事業への展開をバランス良く推進する高度なGTM戦略が求められます。',
        'over-10b' => '大企業として、複数事業部門・子会社を含む全社統合GTM戦略の構築が重要です。イノベーション創出と効率性向上を両立させる戦略的なアプローチが競争力の源泉となります。',
    ];

    $normalizedRevenueRange = normalizeAlphaRevenueRange($revenueRange);

    return $texts[$normalizedRevenueRange] ?? $texts['under-100m'];
}

function alphaLeadText(string $revenueRange, string $grade): string
{
    $texts = [
        'under-100m' => [
            'D' => '創業期として、まずはGTM戦略の基盤作りから始めましょう。限られたリソースで最大の成果を出すため、ターゲット顧客を明確に絞り込み、シンプルで分かりやすい価値提案の確立が最優先課題です。',
            'C' => 'スタートアップとして各機能の役割分担ができ始めています。次のステップは部門間の連携強化です。営業とマーケティングが一体となった顧客獲得プロセスを構築することで、効率的な成長軌道に乗せることができます。',
            'B' => '創業期企業として非常に優秀なGTM基盤を構築できています。この段階でデータドリブンな意思決定体制を導入することで、競合他社に対する大きなアドバンテージを築き、次の成長ステージへの飛躍が期待できます。',
            'A' => '1億円未満の企業でこの成熟度レベルは極めて稀で優秀です。この強固な基盤と仕組み化されたプロセスを活かし、新市場・新チャネルへの戦略的展開により、急速な事業拡大が実現できる段階にあります。',
            'S' => '創業期でありながら最高レベルのGTM戦略を実現している稀有な企業です。この明確な競争優位性を維持しながら、スケーラブルな成長モデルの確立により、短期間での市場リーダーポジション獲得が十分可能です。',
        ],
        'under-1b' => [
            'D' => '成長期企業として、組織拡大に伴うGTM戦略の体系化が急務です。属人的な営業活動から脱却し、再現可能なプロセスの構築により、安定した売上成長基盤を確立することが重要な課題です。',
            'C' => '成長期として各部門の専門性は向上していますが、部門間の連携不足が成長の足かせとなっています。統一されたKPIと定期的な情報共有により、組織全体での顧客価値創造を実現できます。',
            'B' => '成長期企業として理想的なGTM体制を構築できています。この基盤を活かし、データ分析による意思決定の精度向上と、既存顧客からの収益拡大により、持続可能な成長エンジンを確立できる段階です。',
            'A' => '成長期企業として非常に高い成熟度を達成しています。包括的なデータ管理と戦略的な顧客セグメンテーションにより、効率的な市場拡大と収益性の向上を同時に実現できる優位性を持っています。',
            'S' => '成長期企業として最高水準のGTM戦略を実現しています。この高度な仕組みを基盤として、新規事業領域への進出や戦略的パートナーシップの構築により、市場での確固たる地位確立が期待できます。',
        ],
        '1b-5b' => [
            'D' => '拡大期企業として、複数事業・チャネルの統合的なGTM戦略構築が必要です。各部門が個別最適に陥りがちなこの規模では、全社横断的な戦略策定と実行体制の確立により、シナジー効果を最大化できます。',
            'C' => '事業拡大に伴い各機能は専門化していますが、全体最適の視点が不足しています。事業部門間の連携強化と共通KPIの設定により、組織全体での競争力向上と効率的な成長を実現できます。',
            'B' => '拡大期企業として優秀なGTM基盤を確立できています。この段階で高度な顧客分析とマーケットインテリジェンスを活用することで、競合差別化と新規市場開拓の両面で大きな成果を期待できます。',
            'A' => '拡大期企業として非常に高い成熟度を実現しています。データドリブンな戦略実行により、既存市場でのシェア拡大と新規領域への効果的な参入を並行して推進できる強固な基盤を持っています。',
            'S' => '拡大期企業として最高レベルのGTM戦略を実現しています。この卓越した実行力を活かし、業界全体の変革をリードする新しいビジネスモデルの創造や、戦略的M&Aによる更なる成長加速が可能です。',
        ],
        '5b-10b' => [
            'D' => '成熟期企業として、市場での競争優位性維持が重要な課題です。複雑化した組織とプロセスを整理し、効率的なGTM戦略の再構築により、収益性の向上と市場シェアの防衛を同時に実現する必要があります。',
            'C' => '成熟企業として各部門の専門性は高いものの、組織の縦割り化が進んでいます。部門横断的なプロジェクト推進と統合されたカスタマージャーニーの設計により、顧客体験の向上と収益性改善を実現できます。',
            'B' => '成熟期企業として安定したGTM基盤を構築できています。この基盤を活かし、デジタル変革の推進と新たな収益モデルの開発により、市場での地位を更に強化し、次世代への事業継承を成功させることができます。',
            'A' => '成熟期企業として極めて高い戦略実行力を持っています。高度なデータ活用により、既存事業の最適化と新規事業の創造を効果的にバランスさせ、長期的な競争優位性の維持と成長を実現できる段階にあります。',
            'S' => '成熟期企業として最高水準のGTM戦略を実現しています。この卓越した能力を基盤として、市場を牽引するポジションを確立し、新しい市場創造や顧客価値創出型ビジネスでの業界リーダーシップを発揮できます。',
        ],
        'over-10b' => [
            'D' => '大企業として、複数事業部門・子会社を統合したGTM戦略の構築が急務です。組織の複雑性を整理し、全社統一的な顧客価値創造プロセスの確立により、スケールメリットを最大化し、市場での影響力を強化できます。',
            'C' => '大企業として各事業部門の専門性は高いものの、全社最適の視点が不足しています。事業部門横断的な戦略調整機能の強化と、共通プラットフォームの構築により、組織全体での競争力向上を実現できます。',
            'B' => '大企業として優秀な組織横断的GTM体制を構築できています。この基盤を活かし、グローバル展開の加速とイノベーション創出の仕組み化により、持続的な企業価値向上と社会的影響力の拡大を実現できます。',
            'A' => '大企業として非常に高い戦略実行能力を実現しています。高度なデータ統合とAI活用により、複数事業の最適なポートフォリオ管理と、新興市場での戦略的ポジショニングを効果的に推進できる競争優位性を持っています。',
            'S' => '大企業として最高レベルのGTM戦略を実現しています。この卓越した実行力を活かし、業界全体のエコシステム構築において業界標準を形成する立場を確立し、次世代のビジネスモデル創造において他社の模範となる存在です。',
        ],
    ];

    $normalizedRevenueRange = normalizeAlphaRevenueRange($revenueRange);

    return $texts[$normalizedRevenueRange][$grade] ?? $texts['under-100m'][$grade] ?? $texts['under-100m']['D'];
}

$date = new DateTime('now', new DateTimeZone('Asia/Tokyo'));
$formatter = new IntlDateFormatter(
    'ja_JP',
    IntlDateFormatter::NONE,
    IntlDateFormatter::NONE,
    'Asia/Tokyo',
    IntlDateFormatter::GREGORIAN,
    'yyyy年MM月dd日'
);

$score = (float) ($assessmentResult['overallScore'] ?? 0);
$assessmentGrade = (string) ($assessmentResult['grade'] ?? getGrade($score));
$content = getGtmScoreContent($score);

$revenueRangeMap = [
    'under-100m' => '1億円未満',
    'under-1b' => '10億円未満',
    '1b-5b' => '10〜50億円',
    '5b-10b' => '50〜100億円',
    'over-10b' => '100億円以上',
];

$jobTitleMap = [
    'staff' => '担当者',
    'manager' => '課長',
    'director' => '部長',
    'vp' => '本部長・役員クラス',
    'cxo' => '経営層',
];

$departmentMap = [
    'sales' => '営業部門',
    'marketing' => 'マーケティング部門',
    'business' => '事業開発部門',
    'planning' => '経営企画部門',
    'other' => 'その他',
];

$categoryLabels = [
    'who' => ['Who', '市場・顧客理解'],
    'where' => ['Where', 'ターゲティング・ポジショニング'],
    'what' => ['What', '提供価値・メッセージング'],
    'why' => ['Why', '選ばれる理由・差別化'],
    'how' => ['How', 'チャネル・営業プロセス'],
    'when' => ['When', '改善サイクル・プロセス運用'],
];

$categoryOrder = ['who', 'where', 'what', 'why', 'how', 'when'];
$categoryScores = $assessmentResult['categoryScores'] ?? [];
$userRevenueRange = $user['revenue_range'] ?? '';
$revenueRangeLabel = $revenueRangeMap[$userRevenueRange] ?? $userRevenueRange;
$jobTitleLabel = $jobTitleMap[$user['job_title'] ?? ''] ?? ($user['job_title'] ?? '-');
$departmentLabel = $departmentMap[$user['department'] ?? ''] ?? ($user['department'] ?? '-');
$nextActionRevenueRange = isset($assessmentResult['nextActionRevenueRangeOverride']) ? (string) $assessmentResult['nextActionRevenueRangeOverride'] : (string) $userRevenueRange;
$nextActionGrade = isset($assessmentResult['nextActionGradeOverride']) ? (string) $assessmentResult['nextActionGradeOverride'] : $assessmentGrade;
$nextAction = getNextAction($nextActionRevenueRange, $nextActionGrade);
$challengeLabels = getSelectedChallengeLabels($gtmChallenges ?? [], $selectedChallenges ?? []);
$feedbackCategoryOverride = isset($assessmentResult['feedbackCategoryOverride']) ? (string) $assessmentResult['feedbackCategoryOverride'] : null;
$feedbackCategories = selectAlphaFeedbackCategories($categoryScores, $categoryOrder, 1, $feedbackCategoryOverride);
$hasFeedback = !empty($feedbackCategories);
$headerName = alphaPdfTruncate(trim((string) ($user['company'] ?? '-') . ' ' . (string) ($user['name'] ?? '') . ' 様'), 34);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <style>
        @page { size: A4; margin: 0; }

        @font-face {
            font-family: "Montserrat";
            src: url("<?= $fontPath; ?>fonts/Montserrat-Regular.ttf") format("truetype");
            font-weight: normal;
        }

        @font-face {
            font-family: "Montserrat";
            src: url("<?= $fontPath; ?>fonts/Montserrat-Bold.ttf") format("truetype");
            font-weight: bold;
        }

        @font-face {
            font-family: "NotoSansJP";
            src: url("<?= $fontPath; ?>fonts/NotoSansJP-Regular.ttf") format("truetype");
            font-weight: normal;
        }

        @font-face {
            font-family: "NotoSansJP";
            src: url("<?= $fontPath; ?>fonts/NotoSansJP-Bold.ttf") format("truetype");
            font-weight: bold;
        }

        * { box-sizing: border-box; }

        html,
        body {
            margin: 0;
            padding: 0;
            width: 595px;
            height: 842px;
            font-family: "NotoSansJP", sans-serif;
            color: #24394c;
            background: #ffffff;
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
            padding: 12px 10px;
        }

        .alpha-header {
            position: absolute;
            top: 12px;
            left: 10px;
            width: 503px;
            height: 42px;
            border-bottom: 1px solid #9eadbc;
            margin: 0;
        }

        .header-top {
            width: 100%;
            height: 20px;
        }

        .header-name {
            float: left;
            width: 340px;
            padding-left: 4px;
            font-size: 14px;
            line-height: 18px;
            font-weight: bold;
            color: #383838;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .header-date {
            float: right;
            width: 150px;
            text-align: right;
            font-size: 8px;
            line-height: 14px;
            font-weight: bold;
            color: #4c4c4c;
        }

        .header-meta {
            clear: both;
            padding-left: 4px;
            font-size: 10px;
            line-height: 14px;
            font-weight: bold;
            color: #4c4c4c;
            white-space: nowrap;
        }

        .header-name,
        .header-date,
        .header-meta,
        .section-heading .ja,
        .section-heading .en,
        .overall-left-small,
        .overall-left-main,
        .score-label,
        .grade-label,
        .score-value,
        .grade-band-text,
        .ruled-title-text,
        .evaluation-text,
        .category-main,
        .category-sub,
        .cat-label,
        .cat-score-value,
        .cat-grade-value,
        .next-title,
        .next-lead,
        .mini-heading span,
        .challenge-list li,
        .action-list li,
        .action-heading,
        .footer-copy {
            transform: translateY(-0.32em);
            transform-origin: left top;
        }

        .header-name,
        .header-date {
            transform: translateY(-0.52em);
        }

        .header-meta {
            transform: translateY(-0.65em);
        }

        .cat-label,
        .cat-score-value,
        .cat-grade-value {
            transform: none;
        }

        .section-heading {
            position: absolute;
            top: 78px;
            left: 10px;
            width: 503px;
            height: 16px;
            margin: 0;
            font-weight: bold;
        }

        .section-heading .ja {
            position: absolute;
            top: 0;
            left: 4px;
            display: block;
            font-size: 16px;
            line-height: 16px;
            color: #24394c;
        }

        .section-heading .en {
            position: absolute;
            top: 1px;
            left: 275px;
            display: block;
            width: 224px;
            padding: 0;
            font-family: "Montserrat", sans-serif;
            font-size: 12px;
            line-height: 14px;
            text-align: right;
            color: #cacaca;
            white-space: nowrap;
        }

        .overall {
            position: absolute;
            top: 100px;
            left: 10px;
            width: 503px;
            height: 190px;
            border: 1px solid #3d75aa;
            border-radius: 4px;
            overflow: hidden;
            margin: 0;
        }

        .overall-left {
            position: absolute;
            top: 0;
            left: 0;
            width: 168.35px;
            height: 196px;
            padding: 0;
            background: #3d75aa;
            text-align: center;
            color: #ffffff;
            font-weight: bold;
        }

        .overall-icon {
            position: absolute;
            top: 44px;
            left: 68.18px;
            width: 32px;
            height: 32px;
            margin: 0;
        }

        .overall-left-small {
            position: absolute;
            top: 84px;
            left: 20px;
            width: 128.35px;
            font-size: 14px;
            line-height: 14px;
        }

        .overall-left-small .overall-left-line {
            position: absolute;
            top: 7px;
            width: 16.68px;
            border-top: 1px solid #ffffff;
        }

        .overall-left-small .overall-left-line.is-left {
            left: 0;
        }

        .overall-left-small .overall-left-line.is-right {
            right: 0;
        }

        .overall-left-main {
            position: absolute;
            top: 108px;
            left: 24.18px;
            width: 120px;
            margin: 0;
            font-size: 24px;
            line-height: 24px;
        }

        .overall-right {
            position: absolute;
            top: 0;
            left: 168.35px;
            width: 334.65px;
            height: 190px;
            padding: 0;
            background: #f4faff;
        }

        .score-grade-row {
            position: absolute;
            top: 20px;
            left: 12px;
            width: 310.65px;
            height: 54px;
            text-align: center;
            font-weight: bold;
        }

        .score-box,
        .grade-box {
            position: absolute;
            top: 0;
            height: 54px;
            display: block;
        }

        .score-box {
            left: 31.13px;
            width: 80px;
        }

        .grade-box {
            left: 147.52px;
            width: 132px;
        }

        .score-label,
        .grade-label {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            margin: 0;
            font-size: 12px;
            line-height: 12px;
            color: #24394c;
            text-align: center;
        }

        .score-value {
            position: absolute;
            top: 18px;
            left: 0;
            width: 100%;
            margin: 0;
            font-family: "Montserrat", sans-serif;
            font-size: 36px;
            line-height: 36px;
            color: #3d75aa;
            text-align: center;
        }

        .overall-slash {
            position: absolute;
            top: 1.57px;
            left: 119.13px;
            width: 26px;
            height: 52.43px;
            margin: 0;
        }

        .overall-slash::before {
            content: "";
            position: absolute;
            top: -1px;
            left: 10px;
            width: 4px;
            height: 55px;
            background: #d2e0ed;
            transform: skew(-15deg);
        }

        .grade-box > div {
            position: absolute;
            top: 18px;
            left: 0;
            width: 132px;
            height: 36px;
        }

        .grade-pill-list {
            position: relative;
            display: inline-block;
            width: 132px;
            height: 36px;
        }

        .grade-pill {
            position: relative;
            position: absolute;
            display: block;
            margin: 0;
            border-radius: 20px;
            background: #ffffff;
            color: #9eadbc;
            font-family: "Montserrat", sans-serif;
            font-size: 10px;
            line-height: 1;
            font-weight: bold;
            text-align: center;
        }

        .grade-pill-text {
            position: absolute;
            left: 0;
            right: 0;
            top: 2.5px;
            line-height: 1;
            text-align: center;
        }

        .grade-pill.is-active {
            width: 36px;
            height: 36px;
            border-radius: 36px;
            font-size: 24px;
        }

        .grade-pill.is-active .grade-pill-text {
            top: 0.5px;
        }

        .grade-band {
            position: absolute;
            top: 82px;
            left: 12px;
            width: 310.65px;
            height: 23px;
            margin: 0;
            border-radius: 60px;
            background: #3d75aa;
            color: #ffffff;
            font-family: "Montserrat", sans-serif;
            font-size: 12px;
            line-height: 23px;
            font-weight: bold;
            text-align: center;
        }

        .grade-band-text {
            display: block;
            transform: translateY(-0.52em);
            transform-origin: center top;
        }

        .evaluation {
            position: absolute;
            top: 113px;
            left: 12px;
            width: 310.65px;
            margin: 0;
            text-align: center;
        }

        .ruled-title {
            width: 310.65px;
            border-collapse: collapse;
            table-layout: auto;
            margin: 0 0 -4px;
        }

        .ruled-title-line {
            width: auto;
            vertical-align: middle;
        }

        .ruled-title-line span {
            display: block;
            width: 100%;
            border-top: 1px solid #3d75aa;
            transform: translateY(-8px);
            transform-origin: center top;
        }

        .ruled-title-text {
            width: 1%;
            padding: 0 6px;
            text-align: center;
            font-size: 14px;
            line-height: 14px;
            font-weight: bold;
            color: #3d75aa;
            white-space: nowrap;
            transform: translateY(-0.58em);
            transform-origin: center top;
        }

        .evaluation-text {
            margin: -2px 0 0;
            text-align: left;
            font-size: 8px;
            line-height: 1.45;
            font-weight: bold;
            color: #4c4c4c;
            transform: translateY(-0.45em);
            transform-origin: left top;
        }

        .category-grid {
            position: absolute;
            top: 302px;
            left: 10px;
            width: 503px;
            height: 144px;
            margin: 0;
        }

        .category-row {
            position: static;
            width: 503px;
            height: 68px;
            margin: 0;
        }

        .category-card {
            position: absolute;
            box-sizing: border-box;
            width: 161px;
            height: 68px;
            margin: 0;
            border: 1px solid #6d98bf;
            border-radius: 4px;
            overflow: hidden;
            background: #f4faff;
        }

        .cat-pos-0 { left: 0; top: 0; }
        .cat-pos-1 { left: 171px; top: 0; }
        .cat-pos-2 { left: 342px; top: 0; }
        .cat-pos-3 { left: 0; top: 76px; }
        .cat-pos-4 { left: 171px; top: 76px; }
        .cat-pos-5 { left: 342px; top: 76px; }

        .category-head {
            position: relative;
            box-sizing: border-box;
            height: 28px;
            padding: 0;
            background: #0c5395;
            color: #ffffff;
            text-align: center;
            font-weight: bold;
        }

        .category-main {
            position: absolute;
            top: 4px;
            left: 0;
            width: 100%;
            margin: 0;
            font-family: "Montserrat", sans-serif;
            font-size: 9px;
            line-height: 9px;
            transform: none;
        }

        .category-sub {
            position: absolute;
            top: 14px;
            left: 0;
            width: 100%;
            margin: 0;
            font-size: 7px;
            line-height: 7px;
            white-space: nowrap;
            transform: none;
        }

        .category-body {
            box-sizing: border-box;
            height: 32px;
            padding: 4px 16px;
            text-align: center;
            font-size: 1px;
            white-space: nowrap;
        }

        .cat-score,
        .cat-slash,
        .cat-grade {
            display: inline-block;
            vertical-align: middle;
        }

        .cat-score {
            width: 56px;
            text-align: center;
        }

        .cat-grade {
            width: 40px;
            text-align: center;
        }

        .cat-label {
            margin: 0;
            font-size: 8px;
            line-height: 8px;
            font-weight: bold;
            color: #24394c;
        }

        .cat-score-value,
        .cat-grade-value {
            margin: 0;
            font-family: "Montserrat", sans-serif;
            font-size: 24px;
            line-height: 24px;
            font-weight: bold;
            transform: translateY(-0.18em);
            transform-origin: center top;
        }

        .cat-score-value {
            color: #0c5395;
        }

        .cat-slash {
            position: relative;
            width: 14px;
            height: 26px;
            margin: 0 8px;
            font-size: 1px;
            line-height: 1;
            overflow: visible;
        }

        .cat-slash span {
            position: absolute;
            top: -1.5px;
            left: 6px;
            display: block;
            width: 3px;
            height: 29px;
            border-radius: 3px;
            background: #d2e0ed;
            transform: rotate(28deg);
            transform-origin: center center;
        }

        .feedback-panel {
            position: absolute;
            top: 717px;
            left: 10px;
            width: 503px;
            height: 65px;
            margin: 0;
            padding: 0;
            border-radius: 8px;
            overflow: hidden;
        }

        .feedback-heading {
            position: absolute;
            top: 4px;
            left: 4px;
            margin: 0;
            font-family: "Montserrat", "NotoSansJP", sans-serif;
            font-size: 9px;
            line-height: 9px;
            font-weight: bold;
            color: #24394c;
            white-space: nowrap;
            transform: translateY(-0.32em);
            transform-origin: left top;
        }

        .feedback-rows {
            position: absolute;
            top: 20px;
            left: 0;
            width: 503px;
        }

        .feedback-row-card {
            position: relative;
            width: 503px;
            height: 44px;
            margin: 0 0 4px;
            background: #f2f2f2;
            overflow: hidden;
        }

        .feedback-left {
            position: absolute;
            top: 4px;
            left: 8px;
            width: 263px;
            height: 36px;
        }

        .feedback-title-line {
            position: absolute;
            top: 0;
            left: 0;
            width: 263px;
            height: 8px;
        }

        .feedback-category-title {
            position: absolute;
            top: 0;
            left: 0;
            width: 210px;
            margin: 0;
            font-family: "Montserrat", "NotoSansJP", sans-serif;
            font-size: 7.5px;
            line-height: 7.5px;
            font-weight: bold;
            color: #d52154;
            white-space: nowrap;
            transform: translateY(-0.32em);
            transform-origin: left top;
        }

        .feedback-stars {
            position: absolute;
            top: 0;
            right: 0;
            display: block;
            width: 40px;
            height: 8px;
            border: 0;
        }

        .feedback-copy {
            position: absolute;
            top: 10px;
            left: 0;
            width: 263px;
            margin: 0;
            font-family: "Montserrat", "NotoSansJP", sans-serif;
            font-size: 6.4px;
            line-height: 1.55;
            font-weight: bold;
            color: #4c4c4c;
            transform: translateY(-0.32em);
            transform-origin: left top;
        }

        .feedback-right {
            position: absolute;
            top: 4px;
            left: 279px;
            width: 216px;
            height: 36px;
            background: #ffffff;
        }

        .feedback-revenue {
            position: absolute;
            top: 12px;
            left: 8px;
            width: 51px;
            margin: 0;
            font-family: "Montserrat", "NotoSansJP", sans-serif;
            font-size: 5.6px;
            line-height: 5.6px;
            font-weight: bold;
            color: #d52154;
            text-align: center;
            white-space: nowrap;
            transform: translateY(-0.32em);
            transform-origin: center top;
        }

        .feedback-arrow {
            position: absolute;
            top: 9px;
            left: 59px;
            width: 10px;
            height: 18px;
            display: block;
            border: 0;
        }

        .feedback-recommendation {
            position: absolute;
            top: 4px;
            left: 73px;
            width: 127px;
            margin: 0;
            font-family: "Montserrat", "NotoSansJP", sans-serif;
            font-size: 5.6px;
            line-height: 1.55;
            font-weight: bold;
            color: #4c4c4c;
            transform: translateY(-0.32em);
            transform-origin: left top;
        }

        .next-panel {
            position: absolute;
            top: 462px;
            left: 10px;
            width: 503px;
            height: 250px;
            border: 0;
            border-radius: 4px;
            background: transparent;
            overflow: hidden;
        }

        .next-title {
            position: absolute;
            top: 0;
            left: 0;
            width: 503px;
            height: 26px;
            padding: 2px 0 0;
            box-sizing: border-box;
            border-radius: 4px 4px 0 0;
            background: #0e3d68;
            color: #ffffff;
            text-align: center;
            font-size: 12px;
            line-height: 12px;
            font-weight: bold;
            transform: none;
        }

        .next-body {
            position: absolute;
            top: 26px;
            left: 0;
            width: 501px;
            height: 223px;
            border: 1px solid #0e3d68;
            border-top: 0;
            border-radius: 0 0 4px 4px;
            background: #f4faff;
            padding: 0;
            overflow: hidden;
        }

        .next-top {
            position: absolute;
            top: 12px;
            left: 12px;
            width: 479px;
            height: 42px;
            margin: 0;
        }

        .next-grade-cell {
            position: absolute;
            top: -4px;
            left: 0;
            display: block;
            width: 116px;
            height: 49px;
        }

        .next-step-grade-img {
            display: block;
            margin: 0;
        }

        .next-step-grade-img--S {
            width: 114px;
            height: 49px;
        }

        .next-step-grade-img--A,
        .next-step-grade-img--B,
        .next-step-grade-img--C,
        .next-step-grade-img--D {
            width: 113px;
            height: 40px;
            margin-top: 5px;
        }

        .next-lead {
            position: absolute;
            top: 0;
            left: 127px;
            display: block;
            width: 352px;
            height: 42px;
            margin: 0;
            padding: 0;
            font-size: 9px;
            line-height: 9px;
            font-weight: normal;
            color: #0e3d68;
            transform: none;
            overflow: hidden;
        }

        .next-lead-line {
            position: absolute;
            left: 0;
            display: block;
            width: 352px;
            height: 10px;
            line-height: 9px;
            white-space: nowrap;
            transform: translateY(-0.12em);
            transform-origin: left top;
        }

        .mini-heading {
            position: absolute;
            top: 66px;
            left: 12px;
            width: 479px;
            height: 12px;
            margin: 0;
            padding: 0;
            font-size: 12px;
            line-height: 12px;
            font-weight: bold;
            color: #0e3d68;
            overflow: hidden;
        }

        .mini-heading span {
            display: inline-block;
            width: 190px;
            background: #f4faff;
            transform: translateY(-0.28em);
        }

        .mini-heading-line {
            position: absolute;
            top: 6px;
            left: 198px;
            display: block;
            width: 281px;
            height: 0;
            border-top: 1px solid #9eadbc;
        }

        .challenge-list,
        .action-list {
            position: absolute;
            left: 12px;
            width: 479px;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .challenge-list {
            top: 90px;
        }

        .action-list {
            top: 164px;
            z-index: 6;
            width: 399px;
            padding-right: 80px;
        }

        .challenge-list li {
            position: relative;
            height: 12px;
            margin: 0 0 4px;
            padding: 0 0 0 16px;
            font-size: 8px;
            line-height: 8px;
            font-weight: bold;
            color: #0e3d68;
        }

        .action-list li {
            position: relative;
            height: 16px;
            margin: 0;
            padding: 0 0 0 18px;
            font-size: 9px;
            line-height: 16px;
            font-weight: bold;
            color: #0e3d68;
        }

        .challenge-list img {
            position: absolute;
            top: 0;
            left: 0;
            width: 12px;
            height: 12px;
            margin: 0;
        }

        .action-list img {
            position: absolute;
            top: 7px;
            left: 2px;
            width: 12px;
            height: 16px;
            margin: 0;
        }

        .action-heading {
            position: absolute;
            top: 140px;
            left: 12px;
            width: 399px;
            margin: 0;
            z-index: 6;
            font-size: 12px;
            line-height: 18px;
            font-weight: bold;
            color: #d85f08;
            transform: translateY(-0.28em);
        }

        .action-arrow-text {
            margin: 0 4px;
            color: #d85f08;
            font-size: 18px;
            line-height: 10px;
            vertical-align: -1px;
        }

        .action-heading strong {
            color: #0e3d68;
        }

        .next-figure {
            position: absolute;
            right: 15px;
            bottom: 19px;
            width: 71px;
            height: 71px;
            z-index: 3;
        }

        .watermark {
            position: absolute;
            left: 116px;
            top: 198px;
            width: 374px;
            height: 19px;
            opacity: 1;
            z-index: 1;
        }

        .alpha-footer {
            position: absolute;
            left: 10px;
            bottom: 22px;
            width: 503px;
            height: 38px;
            border-top: 1px solid #9eadbc;
            padding-top: 10px;
        }

        .footer-copy {
            position: absolute;
            left: 10px;
            top: 10px;
            width: 330px;
            font-size: 8px;
            line-height: 1.05;
            font-weight: normal;
            color: #383838;
        }

        .footer-copy span {
            display: block;
        }

        .footer-copy-line2 {
            margin-left: 30px;
        }

        .footer-brand {
            position: absolute;
            right: -10px;
            top: 1px;
            width: 167px;
            height: 36px;
        }

        .footer-brand img.footer-brand-image {
            display: block;
            width: 167px;
            height: 36px;
            border: 0;
        }
    </style>
</head>
<body>
<div class="alpha-page<?= $hasFeedback ? ' has-feedback' : '' ?>">
    <div class="alpha-bg"></div>
    <?= renderAlphaSidebar() ?>

    <div class="alpha-content">
        <div class="alpha-header">
            <div class="header-top">
                <div class="header-name"><?= e($headerName) ?></div>
                <div class="header-date">レポート生成日　<?= e($formatter->format($date)) ?></div>
            </div>
            <div class="header-meta">
                【役職】 <?= e($jobTitleLabel) ?>　/　【部署】 <?= e($departmentLabel) ?>　/　【売上規模】 <?= e($revenueRangeLabel) ?>
            </div>
        </div>

        <div class="section-heading">
            <span class="ja">GTM成熟度</span>
            <span class="en">GTM Maturity Assessment by Grade</span>
        </div>

        <div class="overall">
            <div class="overall-left">
                <img class="overall-icon" src="<?= e(alphaImageDataUri('images/alpha/score-icon-flat.png')) ?>" alt="">
                <div class="overall-left-small">
                    <span class="overall-left-line is-left"></span>
                    GTM成熟度
                    <span class="overall-left-line is-right"></span>
                </div>
                <div class="overall-left-main">総合スコア</div>
            </div>
            <div class="overall-right">
                <div class="score-grade-row">
                    <div class="score-box">
                        <p class="score-label">スコア</p>
                        <p class="score-value"><?= e(number_format($score, 1)) ?></p>
                    </div>
                    <div class="overall-slash"></div>
                    <div class="grade-box">
                        <p class="grade-label">グレード</p>
                        <div><?= renderAlphaGradePills($assessmentGrade) ?></div>
                    </div>
                </div>
                <div class="grade-band"><span class="grade-band-text"><?= e(getAlphaGradeBandLabel($assessmentGrade)) ?></span></div>
                <div class="evaluation">
                    <?= renderAlphaRuledTitle($content['description']) ?>
                    <p class="evaluation-text"><?= alphaTextLines(alphaEvaluationText((string) $userRevenueRange), 34) ?></p>
                </div>
            </div>
        </div>

        <div class="category-grid">
            <?php $categoryIndex = 0; ?>
            <?php foreach (array_chunk($categoryOrder, 3) as $rowIndex => $row): ?>
                <div class="category-row">
                    <?php foreach ($row as $index => $cat): ?>
                        <?php
                        $catScore = (float) ($categoryScores[$cat] ?? 0);
                        echo renderAlphaCategoryCard($cat, $categoryLabels[$cat], $catScore, $categoryIndex);
                        $categoryIndex++;
                        ?>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="next-panel">
            <div class="next-title">次のステップ</div>
            <div class="next-body">
                <img class="watermark" src="<?= e(alphaImageDataUri('images/alpha/report-watermark-material.png')) ?>" alt="">

                <div class="next-top">
                    <div class="next-grade-cell"><?= renderAlphaNextStep($assessmentGrade) ?></div>
                    <p class="next-lead"><?= alphaPositionedTextLines(alphaLeadText((string) $userRevenueRange, $assessmentGrade), 38, 14) ?></p>
                </div>

                <p class="mini-heading"><span>解決すべき課題：トップ3 優先課題</span><b class="mini-heading-line"></b></p>
                <ul class="challenge-list">
                    <?php foreach ($challengeLabels as $label): ?>
                        <li><img src="<?= e(alphaImageDataUri('images/alpha/next-check.png')) ?>" alt=""><?= e($label) ?></li>
                    <?php endforeach; ?>
                </ul>

                <?php if ($nextAction): ?>
                    <div class="action-heading">
                        優先アクション <span class="action-arrow-text">›</span> <strong><?= e($nextAction['title'] ?? '') ?></strong>
                    </div>
                    <ul class="action-list">
                        <?php foreach (($nextAction['actions'] ?? []) as $point): ?>
                            <li><img src="<?= e(alphaImageDataUri('images/alpha/next-info-flat.png')) ?>" alt=""><?= e($point) ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                <img class="next-figure" src="<?= $fontPath; ?>images/alpha/next-figure-material.png" alt="">
            </div>
        </div>

        <?php if ($hasFeedback): ?>
            <div class="feedback-panel is-count-<?= e((string) count($feedbackCategories)) ?>">
                <p class="feedback-heading">フィードバック</p>
                <div class="feedback-rows">
                    <?php foreach ($feedbackCategories as $cat => $catScore): ?>
                        <?php if (isset($categoryLabels[$cat])): ?>
                            <?= renderAlphaFeedbackCard($cat, $categoryLabels[$cat], (float) $catScore, $revenueRangeLabel, $userRevenueRange) ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="alpha-footer">
            <div class="footer-copy">
                <span>Go-to-Market戦略設計は、売上につながる仕組みをつくる第一歩です。</span>
                <span class="footer-copy-line2">「何を・誰に・どう届けるか」── 次の打ち手を、一緒に見つけましょう。</span>
            </div>
            <div class="footer-brand">
                <img class="footer-brand-image" src="<?= e(alphaImageDataUri('images/alpha/footer-brand-frame-2657-pdf.png')) ?>" alt="GO-TO-MARKET STRATEGY QR">
            </div>
        </div>
    </div>
</div>
</body>
</html>
