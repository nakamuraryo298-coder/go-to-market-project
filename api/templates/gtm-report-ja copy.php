<?php 
require '../config/helpers.php';
$fontPath = BASE_URL.'/api/';

session_start();
$language           = ($payload['language'] ?? 'en') === 'ja' ? 'ja' : 'en';


function ___($key)
{
    global $langData;
    return $langData['labels'][$key] ?? $key;
}


function removeSpecialChat($content=''){
    return ucwords(str_replace('-',' ',$content));
}
function getGrade($score)
{
    $GRADE_THRESHOLDS = [
        'S' => ['min' => 9.0, 'max' => 10.0],
        'A' => ['min' => 7.5, 'max' => 8.9],
        'B' => ['min' => 6.0, 'max' => 7.4],
        'C' => ['min' => 4.0, 'max' => 5.9],
        'D' => ['min' => 1.0, 'max' => 3.9],
    ];
    foreach ($GRADE_THRESHOLDS as $grade => $range) {
        if ($score >= $range['min'] && $score <= $range['max']) {
            return $grade;
        }
    }
    return 'D'; // fallback safety
}

function getGtmScoreContent(float $score): array
{
    global $langData;

    $grade = getGrade($score);

    if (
        empty($langData['gradeContent']) ||
        !isset($langData['gradeContent'][$grade])
    ) {
        return [
            'grade' => $grade,
            'heading' => '',
            'description' => ''
        ];
    }

    $raw = $langData['gradeContent'][$grade];

    return [
        'grade' => $grade,
        'heading' => $raw['heading'] ?? '',
        'description' => $raw['description'] ?? ''
    ];
}

$score   = (float) $assessmentResult['overallScore'];
$content = getGtmScoreContent($score);

function e($v)
{
    return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
}


$jaCategorySubLabels = [
    'who'   => 'market_customer_understanding',
    'where' => 'hunting',
    'what'  => 'providing_value_messaging',
    'why'   => 'the_reason_for_choosing',
    'how'   => 'channel_business_process',
    'when'  => 'improve_cycle_process_operation'
];

// Revenue range mapping
$revenueRangeMap = [
    'ja' => [
        'under-100m' => '1億円未満 / Under ¥100M',
        'under-1b'   => '10億円未満 / Under ¥1B',
        '1b-5b'      => '10〜50億円 / ¥1B–¥5B',
        '5b-10b'     => '50〜100億円 / ¥5B–¥10B',
        'over-10b'   => '100億円以上 / Over ¥10B',
    ],
];

// Job title mapping
$jobTitleMap = [
    'ja' => [
        'staff'    => '担当者 / Staff',
        'manager'  => '課長 / Manager',
        'director' => '部長 / Director',
        'vp'       => '本部長・役員クラス / VP',
        'cxo'      => '経営層（CxO, CEO, COO, CFO, CMOなど） / CxO / Executive',
    ],
];

// Department mapping
$departmentMap = [
    'ja' => [
        'sales'                => '営業部門 / Sales Department',
        'marketing'            => 'マーケティング部門 / Marketing Department',
        'business-development' => '事業開発部門 / Business Development Department',
        'corporate-planning'   => '経営企画部門 / Corporate Planning Department',
        'other'                => 'その他 / Other',
    ],
];
// echo $job_title;
// Select the correct language map
$jobTitleLabel     = $jobTitleMap[$language][$job_title] ?? $job_title;
// echo $jobTitleLabel;
$departmentLabel   = $departmentMap[$language][$department] ?? $department;
$revenueRangeLabel = $revenueRangeMap[$language][$revenue_range] ?? $revenue_range;

function getFeedback($category, $score)
{
    global $langData;

    $star = getStars($score); // convert score → 1 or 2

    return $langData['individualFeedback'][$category][$star]['text'] ?? '';
}
function getStars($score)
{
    if ($score < 2) return 1;
    return 2;
}

function renderStars($score)
{
    $filled = getStars($score);

    $starFull = '<span style="font-family: DejaVu Sans;">&#9733;</span>';
    $starEmpty = '<span style="font-family: DejaVu Sans;">&#9734;</span>';

    return str_repeat($starFull, $filled) .
           str_repeat($starEmpty, 5 - $filled);
}

function getRevenueTag($revenue_range, $language)
{
    return match($revenue_range){
        'under-100m' => '1億円未満',
        'under-1b'   => '10億円未満',
        '1b-5b'      => '10〜50億円',
        '5b-10b'     => '50〜100億円',
        'over-10b'   => '100億円以上',
        default => 'under-100m'
    };
}
function getRecommendation($category, $score)
{
    global $langData, $revenue_range;

    $star = getStars($score);

    return $langData['individualFeedback'][$category][$star]['recommendation'][$revenue_range] ?? '';
}

function insertSoftBreaks($text) {
    // return mb_convert_encoding($text, 'UTF-8', 'auto');
    $text = mb_convert_encoding($text, 'UTF-8', 'auto');

    // Insert <wbr> after each character
    return preg_replace('/(.)/u', '$1<wbr>', $text);
}
function getNextAction($revenueRange, $grade)
{
    global $langData;

    // $nextActions = $langData['nextAction'] ?? [];
    $grade = strtoupper(trim($grade));
    $revenueRange = trim($revenueRange);

    $order = ['D','C','B','A','S'];

    $index = array_search($grade, $order);
    if ($index === false) return null;

    // If already S → return S block
    if ($grade === 'S') {
        return $langData['nextAction'][$revenueRange]['S'] ?? null;
    }

    $nextGrade = $order[$index + 1] ?? 'S';

    $key = $grade . '_to_' . $nextGrade;
    return $langData['nextAction'][$revenueRange][$key] ?? null;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <style>
            @font-face {
                font-family: "Montserrat";
                src: url("<?= $fontPath;?>fonts/Montserrat-Regular.ttf") format("truetype");
                font-weight: normal;
            }

            @font-face {
                font-family: "Montserrat";
                src: url("<?= $fontPath;?>fonts/Montserrat-Bold.ttf") format("truetype");
                font-weight: bold;
            }
            @font-face {
                font-family: "NotoSansJP";
                src: url("<?= $fontPath;?>fonts/NotoSansJP-ExtraBold.ttf") format("truetype");
                font-weight: bolder;
            }
            @font-face {
                font-family: 'NotoSansJP';
                src: url('<?= $fontPath;?>fonts/NotoSansJP-Regular.ttf') format('truetype');
                font-weight: normal;
            }

            @font-face {
                font-family: 'NotoSansJP';
                src: url('<?= $fontPath;?>fonts/NotoSansJP-Bold.ttf') format('truetype');
                font-weight: bold;
            }
            <?php if($language=='en'){?>
            body {
                margin: 0;
                padding: 0;
                font-family: "Montserrat", sans-serif;
                background: #eee;
            }
            <?php }else if($language=='ja'){?>
            body {
                margin: 0;
                padding: 0;
                font-family: "NotoSansJP", sans-serif;
                background: #eee;
            }
            <?php } ?>
            

            .li-font {
                font-size: 14px;
            }

            table {
                border-collapse: collapse;
            }

            .page {
                width: 100%;
                height: 100%;
               
            }

            @page {
                size: A4;
                margin: 0;
            }
            
            .footer-section {
                position: relative;
                bottom: 0px;
            }

            .page {
                width: 100%;
                height: 100%;

                background-image: url("<?= $fontPath;?>images/background-4x.png");
                background-size: contain;
                background-repeat: no-repeat;
                background-position: top right;
            }

            @page {
                size: A4;
                margin: 0;
            }

            html,
            body {
                width: 100%;
                height: 100%;
            }

            .ja-text {
                word-break: break-all;
                line-break: strict;
                white-space: normal;
            }

            .no-break {
                page-break-inside: avoid;
            }

            .left-bar {
                width: 60px;
                height: 100%;
                padding: 0;
                vertical-align: top;
                background: #0c5395;
            }

            .left-bar img {
                display: block;
                background-repeat: no-repeat;
                background-position: center;
                background-size: cover;
                /*height: auto;*/
                width: 30px;
            }

            .main-title h1 {
                font-size: 22px;
                color: #24394c;
                margin-top: 2px;
                padding-top: 2px;
                margin-bottom: 4px;
            }
            .content {
                padding: 0px 20px 5px 20px;
                background-image: url("<?= $fontPath;?>images/background.png");
                background-size: cover;
                background-repeat: no-repeat;
                background-position: top right;
                position: relative;
                height:1030px ;
            }

            .header-title {
                font-size: 12px;
                margin: 0px;
                margin-top: -5px;
                margin-bottom: -15px;
                color: #383838;
                font-weight: 700;
                font-style: bold;
            }

            .small-text {
                font-size: 10px;
                color: #4c4c4c;
                margin-bottom: 0px;
                font-weight: 700;
                font-style: bold;
            }
            .overall-right .small-text {
                font-weight: 700;
            }
            .info-container {
                border-bottom: 1px solid #4c4c4c;
            }

            .overall-table {
                width: 100%;
                min-height: 150px;
            }
            .overall-wrapper {
                border: 1px solid #0c5395;
                border-radius: 6px;
                background: #edf6ff;
                
            }
            .overall-wrapper h3 {
                font-size: 20px;
                font-weight: 700;
            }
            .gtm-p {
                margin-top: 25px;
                margin-bottom: -10px;
            }
            .overall-left {
                width: 35%;
                background: #3d75aa;
                color: #fff;
                padding: 10px;
                text-align: center;
                border-radius: 5px 0px 0px 5px;
                
            }

            .overall-right {
                width: 65%;
                padding: 10px;
                
            }

            .gtm-score .big-score {
                font-size: 35px;
                font-weight: bold;
                color: #3c73a8;
                padding-right: 15px;
            }

            .gtm-grades p.grade {
                background: #9eadbc;
                color: #24394c;                
                height: 15px;
                border-radius: 50%;
                font-weight: bold;
                display: inline-block;
                width: 15px;
                margin-right: 0px;
                font-size: 12px;
                line-height: 18px;
                text-align: center;
            }
            .gtm-grades p.grade.active {
                position: relative;
                top: 5px;
                background: #3d75aa;
                color: #fff;
                height: 22px;
                border-radius: 50%;
                font-weight: bold;
                display: inline-block;
                width: 22px;
                font-size: 25px !important;
                line-height: 22px;
                text-align: center;
            }
            td.slash-cus,
            p.slash-cus {
                font-size: 40px;
                font-weight: 700;
                color: #9eadbc;
                padding: 0px 15px 10px 0px;
            }
            .gtm-grades p.slash-cus {
                font-size: 40px;
            }
            .flex-grade {
                display: flex;
                align-items: center;
                flex-wrap: no-wrap;
            }
            .flex-grade {
                display: flex;
                align-items: center; 
                gap: 6px;
            }

            .flex-grade .grade {
                margin: 0;
                font-size: 16px;
            }

            .slash-cus {
                margin: 0;
                font-weight: bold;
                position: relative;
                top: -7px; 
            }
            .overall-right .gtm-score p.top-head,
            .overall-right .gtm-grades p.top-head {
                font-size: 16px;
                color: #4c4c4c;
                font-weight: 700;
            }
            table .center-table {
                margin: 0 auto;
                margin-bottom: 2px;
            }
            h4.heading-color {
                color: #24394c;
                font-size: 22px;
                font-weight: 700;
                margin-bottom: 10px;
                margin-top: 10px;
            }
            .metrics-table {
                width: 100%;
                margin-top: 10px;
            }

            .metric-title {
                background: #6d98bf;
                color: #fff;
                text-align: center;
                padding: 10px;
                font-weight: bold;
                border-radius: 5px 5px 0px 0px;
                font-size: 13px;
                line-height: 8px;
            }
            .center-row td {
                text-align: center;
                vertical-align: middle;
                padding: 5px;
            }
            .center-row td {
                padding-top: 0px;
                padding-bottom: 4px;
            }

            .gtm-score p strong,
            .gtm-grades p strong {
                font-size: 35px;
                color: #0c5395;
                font-weight: 700;
            }

            .metric-content {
                text-align: center;
                padding: 5px;
                padding-bottom: 0 !important;
            }

            .metric-box {
                padding: 0px;
                text-align: center;
                border-radius: 6px;
                background: #f7fbff;
            }
            .metrics-table td.row-td {
                    padding-right: 10px;
                }

            .metrics-table td.row-td:last-child {
                    padding-right: 0;
                }
            .metrics-wrapper {
                border: 1px solid #3d75aa;
                border-radius: 7px;
                padding: 0px;

                margin-top: 8px;
            }
             .feedback-left {
                border-radius: 7px;
            }
            .box-flex-cus {
                display: flex;
                align-items: center;
                column-gap: 20px;
                justify-content: center;
                margin-bottom: -20px;
            }
            .inner-gtm-div {
                margin-bottom: -10px;
            }

            .metric-tr {
                background: #6f9fc8;
                border-radius: 6px 6px 0px 0px;
            }
            .center-row p.slash-cus {
                top: 4px;
                padding-right: 0;
            }
            .gtm-score p,
            .gtm-grades p {
                margin: 2px 0px ;
                font-size: 8px;
                color: #24394c;
                font-weight: 800;

               
            }

            .gtm-grades span {
                font-size: 22px;
            }
            .list-table {
                width: 100%;
                border-collapse: collapse;
                margin: 0;
                padding: 0;
            }

            .list-table td {
                vertical-align: center;
                padding-bottom:3px;
                padding-top: 3px;
            }

           
            .list-table td.text {
                padding-left: 2px; 
                font-size: 10px;
                line-height: 1.4;
                color: #24394c;
                font-weight: 600;
                font-family: "Montserrat", sans-serif;
            }


            .bottom-table {
                width: 100%;
                margin-top: 0px;
            }

            .challenge-wrapper {
                background: #f5f7f9;
                padding: 5px;
            }

            .challenge-left {
                vertical-align: top;
            }

            .challenge-left img {
                width: auto;
                display: block;
            }

            .challenge-content {
                vertical-align: top;
                padding-left: 10px;
            }

            .challenge-title {
                font-size: 16px;
                font-weight: bold;
                margin-bottom: 6px;
            }

            .challenge-list {
                list-style: none;
                padding: 0;
                margin: 0;
            }
             .list-table td.check {
                width: 2px;
                padding-right: 5px;
                margin-right:10px;
                background: url("<?= $fontPath;?>images/Vector-check.png") no-repeat center center;
                background-size: contain;
                
            }

            .challenge-list li {
                background: url("images/report.png") no-repeat left 4px;
                padding-left: 0px;
                margin-bottom: 8px;
                font-size: 8px;
            }
            .space-cus {
                display: flex;
                flex-direction: inherit;
                justify-content: space-between;
                object-fit: contain;
            }
            .li-font {
                font-size: 8px;
                color: #24394c;
                font-weight: 600;
                font-family: "Montserrat", sans-serif;
                padding-left: 0;
            }
            .space-cus img {
                object-fit: content;
            }
            .footer-section{
              position: absolute;
             padding-left: 20px;
             padding-right: 20px;
              bottom: 0;
              left: 0px;
            }
            .feedback-header {
                background: #6f97c7;
                color: #fff;
                font-weight: bold;
                font-size: 9px;
                padding: 4px;
                text-align: center;
            }
            .stars {
                font-family: DejaVu Sans, Arial, sans-serif;
            }

            .feedback-row {
                background: #f5f9ff;
                border-bottom: 1px solid #D2E0ED;
            }
            .feedback-wrapper tr td.feedback-header {
                border-radius: 5px 6px 0 0;
            }
            .feedback-left {
                padding: 5px 10px;
            
                vertical-align: top;
                position: relative;
            }

            .feedback-title {
                color: #D52154;
                font-size: 10px;
                font-weight: bold;
                margin: 0px;
            }

            .feedback-text {
                font-size: 9px;
                color: #333;
                margin:0px;
                line-height: 1.4;
                font-weight: 700;
            }

            .stars {
                color: #D52154;
                font-size: 11px;
                margin: 0;
                position:absolute;
                top:10px;
                right:10px;
            }

            .feedback-right {
                padding: 5px 10px;
                vertical-align: top;
            }
             p.en-head-text{
               
               position: relative;
               top: 5px;
            }
            <?php if($language=='en'){?>

               .gtm-grades p.grade {
                 padding: 3px 8px 13px 8px;
                } 
                .gtm-grades p.grade.active {
                    padding: 10px 12px 16px 12px;
                }
                .inner-gtm-div{
                    padding-bottom: 5px;
                }
                p.big-score{
                  margin-top: 10px;
                }
                .header-title{
                  padding-bottom: 3px;
                }
                .feedback-left{
                   width: 55% !important;
                }
                .feedback-right{
                    width: 45% !important;
                    white-space: wrap;
                }
               

              .feedback-info .tag,
              .feedback-info .img-inline,
             .feedback-info .recommendation {
             display: inline;
             vertical-align: middle;
             margin: 0;
                 }
                  .feedback-info span,
            .feedback-info img,
            .feedback-info p {
                display: inline-block;
                vertical-align: middle;
                margin: 0;
                line-height: 2px;
            }

            .feedback-info .tag {
                font-weight: bold;
                margin-right: 4px;
            }

            .feedback-info .img-inline img {
                margin: 0 4px;
            }

            .feedback-info .recommendation {
                font-size: 10px;
                border-radius: 4px;
                width: 70%;
                line-height: 0;
            }
            .feedback-info .tag{
             padding-top: 4px;
            }

            <?php }else{?>
                .gtm-grades p.grade {
                 padding:2px 9px 15px 9px;
                font-family:'Montserrat', sans-serif;
                } 
                .gtm-grades p.grade.active {
                    font-family:'Montserrat', sans-serif;
                    padding:10px 14px 17px 14px;
                }
               
                .gtm-grades p.grade {
                background: #9eadbc;
                color: #24394c;                
                height: 15px;
                border-radius: 50%;
                font-weight: bold;
                display: inline-block;
                width: 15px;
                margin-right: 0px;
                font-size: 12px;
                line-height: 18px;
                text-align: center;
            }
            .gtm-grades p.grade.active {
                position: relative;
                top: 5px;
                background: #3d75aa;
                color: #fff;
                height: 22px;
                border-radius: 50%;
                font-weight: bold;
                display: inline-block;
                width: 22px;
                font-size: 25px !important;
                line-height: 22px;
                text-align: center;
            }
            .metric-title {
                padding: 5px;
            }
            p.slash-cus {
                padding: 0px 15px 0px 0px;
            }
            h4.heading-color {
                color: #24394c;
                font-size: 22px;
                font-weight: 700;
                margin-bottom: 8px;
                margin-top: 8px;
            }
            p.ja-head-text{
               
               position: relative;
               top: 17px;
            }
            p.big-score{
                padding-top: 10px
            }
            .icon-list {
                margin: 4px 0 0 14px;
                padding: 0;
                list-style: none;
            }
            .icon-list li {
                background: url("<?= $fontPath; ?>images/Vector-icon.png") no-repeat left 4px;
                background-size: 12px;
                padding-left: 18px;
                margin-bottom: 4px;
                font-weight: bold;
                font-family: 'NotoSansJP', sans-serif;
                color: #4C4C4C;
            }
            <?php } ?>

            .feedback-info {
                background: #fff;
                padding: 4px;
                align-items: center;
                display: flex;
             
            }

            .tag {
                display: inline-block;
                color: #D52154;
                font-size: 10px;
                font-weight: bold;
                margin-bottom: 2px;
            }

            .recommendation {
                font-size:9px;
                color: #333;
                margin: 0;
                line-height: 10px;
            }
            .feedback-right {
                vertical-align: top;
            }

            .tag {
                display: inline-block;
                margin-right: 4px;
                vertical-align: top;
            }

            .img-inline {
                display: inline-block;
                margin-right: 6px;
                vertical-align: top;
            }

            .img-inline img {
                display: block;
            }

            .recommendation {
                display: inline-block;
                width: 70%; /* IMPORTANT for wrapping */
                vertical-align: top;
            }
            .ja-text,
            body.ja {
                font-family: "NotoSansJP", sans-serif !important;
            }

            .ja-head-text {
                font-family: "NotoSansJP", sans-serif !important;
                font-weight: bold;
            }
            
            .big-score{
                position: relative;
                top: -20px !important;
            }
            h4.heading-color{
                margin-bottom: :-20px;
                line-height: 10px;
            }
            .en-text{
                color: #CACACA;
                font-size: 12px;
                font-weight: 700;
                font-style: bold;
            }
            .next-step-box {
                position: relative;
            }

            .text-area {
                position: relative;
                top: -40px;
                left: 50px;
            }
            .jp-text{
                color: #24394C;
                font-style: bold;
                font-weight: 700;
                font-size: 16px;
            }
            .jp-text_plain{
                color: #24394C;
                font-style: bold;
                font-weight: 700;
                font-size: 6px;
            }
            img.down_arrow {
                width: auto;
                left: -14px;
                position: relative;
                height: 50px;
            }
        </style>
    </head>
    <?php 
    $date   =   date('d/m/Y');
    $dt = DateTime::createFromFormat('d/m/Y', $date);

    // Japanese date formatter
    $formatter = new IntlDateFormatter(
        'ja_JP',
        IntlDateFormatter::NONE,
        IntlDateFormatter::NONE,
        'Asia/Tokyo',
        IntlDateFormatter::GREGORIAN,
        'yyyy 年MM 月dd 日'
    );

    if ($language === 'ja') {
        // JP 5W1H order
        $fixedOrder = ['who', 'where', 'what', 'why', 'how', 'when'];
    } else {
        // EN MOVE order
        $fixedOrder = ['m', 'o', 'v', 'e'];
    }

    // Build low-score list with sorting priority
    $lowScoreCategories = [];

    foreach ($assessmentResult['categoryScores'] as $cat => $score) {
        if ($score < 2) {
            $lowScoreCategories[$cat] = $score;
        }
    }

    // Sort based on your priority rules
    if (!empty($lowScoreCategories)) {

        // answers array (adjust key if needed)
        $answers = $assessmentResult['answers'] ?? [];

        uksort($lowScoreCategories, function ($a, $b) use ($answers, $fixedOrder) {

            // 1️⃣ Answer priority (1 before 2)
            $answerA = $answers[$a] ?? 2;
            $answerB = $answers[$b] ?? 2;

            if ($answerA != $answerB) {
                return $answerA <=> $answerB;   // 1 first
            }

            // 2️⃣ Fixed category order
            $posA = array_search(strtolower($a), $fixedOrder);
            $posB = array_search(strtolower($b), $fixedOrder);

            if ($posA === false) $posA = 999;
            if ($posB === false) $posB = 999;

            return $posA <=> $posB;
        });
    }

    ?>
    <body class="<?= $language === 'ja' ? 'ja' : '' ?>">
    <table class="page">
        <tr>
            <td class="left-bar" style="position: relative">
                <table width="100%" height="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td colspan="2" align="center" valign="top">
                            <img style="position: relative; top: 20px" src="<?= $fontPath;?>images/report-4x.png" />
                        </td>
                    </tr>

                    <tr>
                        <td align="center" valign="bottom">
                            <img style="position: absolute; bottom: 0; right: 5px; width: 100%" src="<?= $fontPath;?>images/Vector-4x.png"/>
                        </td>
                    </tr>
                </table>
            </td>
            <td class="content" valign="top">
                <div class="info-container">
                    <table width="100%" style="margin-bottom: 10px; margin-top: 20px;">
                        <tr style="margin-top:20px">
                            <td valign="top">
                                <h2 class="header-title" ><?= htmlspecialchars($user['company'] ?? '-') ?> <?= $user['name'];?></h2>
                                <p class="small-text" style="margin-left:-5px">
                                    <strong>【 <?= ___('job') ?> 】<?= $jobTitleLabel;?></strong> &nbsp;
                                    <strong>/ 【 <?= ___('department') ?> 】<?= $departmentLabel;?></strong> <br />
                                    <strong>【 <?= ___('revenue') ?> 】<?= $revenueRangeLabel;?></strong>
                                </p>
                            </td>
                            <td align="right" valign="top" class="small-text">
                                <?= ___('report_generated') ?> <strong>
                                    <?php if($language=='en'){
                                        echo $date;
                                    }else{
                                        echo $formatter->format($dt);
                                        // $dt;
                                    }?>
                                </strong>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="main-title" style="width: 100%; margin-bottom: 35px; padding-top: 15px">
                    <h1 style="margin:0; line-height:16px; float:left;">
                        <?= ___('gtm_metrics') ?>
                    </h1>
                    <p style="margin:0; line-height:16px; color:#CACACA; font-weight: bold; float:right; font-family:'NotoSansJP', sans-serif;">                       
                        GTM成熟度評価（グレード別）                   
                    </p>
                </div>
                <div class="overall-wrapper">
                    <table class="overall-table">
                        <tr>
                            <td class="overall-left">
                                <img src="<?= $fontPath;?>images/gtm-icon.png" />

                                <p style="font-weight: bold;" class="gtm-p">
                                    <span style="position: relative; bottom: 6px; right: 10px">
                                        <img src="<?= $fontPath;?>images/horizontal-line.png"/>
                                    </span>
                                    <?= ___('gtm_maturity') ?>
                                    <span style="position: relative; bottom: 6px; left: 10px">
                                        <img src="<?= $fontPath;?>images/horizontal-line.png">
                                    </span>
                                </p>
                                <h3><?= ___('overall_score') ?></h3>
                            </td>
                            <td class="overall-right" valign="top">
                                <table cellpadding="0" cellspacing="0" class="center-table">
                                    <tr>
                                        <!-- Score label -->
                                        <td align="center" valign="top" class="gtm-score">
                                            <p class="top-head"><?= ___('score') ?></p>
                                            <p class="big-score" style="font-weight:bold; <?= $language === 'ja' ? "font-family: 'Montserrat', sans-serif;" : "font-family:'Montserrat', sans-serif;"?>"><?= $assessmentResult['overallScore'] ?></p>
                                        </td>

                                        <!-- Score value -->
                                        <td>
                                            <p style="position: relative; top: 0px" align="center" valign="bottom" class="slash-cus" >
                                                <img style="position: relative; top: 14px" src="<?= $fontPath;?>images/slash-1.png" />
                                            </p>
                                        </td>
                                        <?php 
                                        $assessmentGrade = $assessmentResult['grade'];
                                        ?>
                                        <td align="center" valign="top" class="gtm-grades">
                                            <p class="top-head" style="margin-bottom: 5px"><?= ___('grade') ?></p>
                                            <div class="flex-grade">
                                                <p class="grade <?php if($assessmentGrade=='D') echo 'active';?>">D</p>
                                                <p class="grade <?php if($assessmentGrade=='C') echo 'active';?>">C</p>
                                                <p class="grade <?php if($assessmentGrade=='B') echo 'active';?>">B</p>
                                                <p class="grade <?php if($assessmentGrade=='A') echo 'active';?>">A</p>
                                                <p class="grade <?php if($assessmentGrade=='S') echo 'active';?>">S</p>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                                <h4 style="margin-bottom: 0; line-height:0px;" class="heading-color"><?= e($content['heading']) ?></h4>
                                <?php if($language=='en'){?>
                                <p  class="small-text text-color" style="font-family: 'Montserrat', sans-serif;color: #4c4c4c;">
                                    <?= nl2br(e($content['description'])) ?>
                                </p>
                                <?php }else if($language=='ja'){?>
                                <p style="margin-top: 0; position: relative; bottom: 0px;" class="small-text text-color" style="
                                    font-family: 'NotoSansJP', sans-serif;
                                    color: #4c4c4c;
                                    white-space: pre-wrap;
                                    text-align: left;
                                ">
                                    <?= insertSoftBreaks(e($content['description'])) ?>
                                </p>
                                <?php } ?>
                            </td>
                        </tr>
                    </table>
                </div>
                <table class="metrics-table" cellspacing="10">
                    <?php
                        $hasLowScore = false;
                        foreach ($assessmentResult['categoryScores'] as $s) {
                            if ($s < 2) {
                                $hasLowScore = true;
                                break;
                            }
                        }
                        // Decide layout
                        if ($language == 'ja') {

                            // 🇯🇵 JA → ALWAYS normal 2 rows (3 per row)
                            $chunks = array_chunk($assessmentResult['categoryScores'], 3, true);

                        } else {

                            // 🇬🇧 EN
                            if ($hasLowScore) {
                                // If any score < 2 → ONE single row
                                $chunks = [ $assessmentResult['categoryScores'] ];
                            } else {
                                // Normal → 2 rows (2 per row)
                                $chunks = array_chunk($assessmentResult['categoryScores'], 2, true);
                            }
                        }

                        
                        foreach ($chunks as $row):
                        ?>
                    <tr>
                        <?php foreach ($row as $cat => $score): ?>
                        <td width="24.33%"  class="row-td">
                            <div class="metrics-wrapper">
                                <table
                                    width="100%"
                                    class="metric-box"
                                    style="table-layout: fixed"
                                    cellpadding="5"
                                    cellspacing="10"
                                >
                                    <tr>
                                        <td colspan="1" class="metric-title" align="center">
                                            <span style="text-transform: capitalize; margin-top: -10px; <?= $language === 'ja' ? "font-family:'NotoSansJP', sans-serif;" : "font-family:'Montserrat', sans-serif;"?>"><?= ___($cat) ?></span>
                                            <?php if ($language === 'ja' && isset($jaCategorySubLabels[$cat])): ?>
                                            <div style="font-size:9px; font-weight:bold; color: white;font-family: 'NotoSansJP', sans-serif; ">
                                                <?= ___($jaCategorySubLabels[$cat]) ?>
                                            </div>
                                            <?php endif; ?>
                                        </td>
                                    </tr>

                                    <tr class="center-row">
                                        <td align="center" valign="middle" width="100%">
                                            <div class="inner-gtm-div" style="margin-bottom:-30px; display: inline-block; text-align: center" >
                                                <div class="gtm-score" style="display: inline-block; text-align: center" >
                                                    <p class="<?= $language === 'ja' ? 'ja-head-text' : '' ?> <?= $language === 'en' ? 'en-head-text' : '' ?>" style="font-weight:bold; <?= $language === 'ja' ? "font-family:'NotoSansJP', sans-serif;" : "font-family:'Montserrat', sans-serif;"?>"><?= ___('score') ?></p>
                                                    
                                                    <p style="font-weight:bold; margin-bottom: 10px; <?= $language === 'ja' ? "font-family: 'Montserrat', sans-serif;" : "font-family:'Montserrat', sans-serif;"?>"><strong><?= number_format($score, 1) ?></strong></p>
                                                </div>

                                                <div class="slash-cus" style="display: inline-block; margin: 0 8px; vertical-align: middle">
                                                    <img src="<?= $fontPath;?>images/slash-2.png" alt=""/>
                                                </div>

                                                <div class="gtm-grades" style="display: inline-block; text-align: center" >
                                                    <p class="<?= $language === 'ja' ? 'ja-head-text' : '' ?> <?= $language === 'en' ? 'en-head-text' : '' ?>" style="font-weight:bold; "><?= ___('grade') ?></p>
                                                    <p style="font-weight:bold; margin-bottom: 10px; <?= $language === 'ja' ? "font-family: 'Montserrat', sans-serif;" : "font-family:'Montserrat', sans-serif;"?>"><strong><?= getGrade($score) ?></strong></p>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                        <?php endforeach; ?>
                    </tr>
                    <?php endforeach; ?>
                </table>
                <?php if($hasLowScore){?>
                <div class="feedback-wrapper metrics-wrapper" style="margin-bottom: 8px; margin-top: 8px">
                    <table width="100%" cellpadding="0" cellspacing="0" class="feedback-table">
                        <tr style="border-radius: 10px">
                            <td colspan="2" class="feedback-header"><?= ___('individual_feedback');?></td>
                        </tr>

                        <?php 
                        $lowScoreLimit = 2;   // how many rows you want to show
                        $lowScoreCount = 0;   // counter
                        ?>

                        <?php foreach ($lowScoreCategories as $cat => $score): ?>
                            
                            <?php if (getStars($score) <= 2 && $lowScoreCount < $lowScoreLimit): ?>
                                <?php $lowScoreCount++; ?>   <!-- increase counter -->

                                <!-- ROW -->
                                <tr style="border-radius: 10px; padding-bottom:0px" class="feedback-row">
                                    
                                    <!-- LEFT -->
                                    <td style="width: 55%; !important" class="feedback-left">
                                        <p class="feedback-title">
                                            <?= ucfirst($cat) ?>
                                            <?php if ($language === 'ja' && isset($jaCategorySubLabels[$cat])): ?>
                                            <span style="font-size:9px;">
                                                <?= ___($jaCategorySubLabels[$cat]) ?>
                                            </span>
                                            <?php endif; ?>        
                                        </p>

                                        <p class="feedback-text">
                                            <?= insertSoftBreaks(getFeedback($cat, $score)); ?>
                                        </p>

                                        <p class="stars"><?= renderStars($score); ?></p>
                                    </td>

                                    <!-- RIGHT -->
                                    <td style="width: 45%; !important" class="feedback-right">
                                        <div class="feedback-info" style="padding-bottom: 5px;">
                                            <span width="20%" class="tag">
                                                <?= getRevenueTag($revenue_range, $language); ?>
                                            </span>

                                            <span width="10%" class="img-inline">
                                                <img src="<?= $fontPath;?>images/vector-arrow.png" style="position: relative; top: 5px" alt="" />
                                            </span>

                                            <p width="70%" class="recommendation">
                                                <?= insertSoftBreaks(getRecommendation($cat, $score)); ?>
                                            </p>
                                        </div>
                                    </td>
                                </tr>

                            <?php endif; ?>

                            <?php if ($lowScoreCount >= $lowScoreLimit) break; ?>  <!-- stop loop -->

                        <?php endforeach; ?>

                    </table>
                </div>
                <?php } ?>

                <?php 
                    $gradeOrder = ['D', 'C', 'B', 'A', 'S'];
                    // $grade = getGrade($score);
                    $grade  =   $assessmentGrade;
                    $currentIndex = array_search($grade, $gradeOrder);

                    $currentGrade = $gradeOrder[$currentIndex];
                    $nextGrade = $gradeOrder[$currentIndex + 1] ?? null;
                ?>

                <!-- BOTTOM -->
                <table class="bottom-table" width="100%" cellspacing="0" cellpadding="0" style="margin-top: 15px;">
                    <tr>
                        <!-- LEFT IMAGE -->
                        <td width="30%" valign="top" class="challenge-left">
                            <div class="next-step-box">
                                <div class="icon-circle">
                                    <img src="<?= $fontPath ?>/images/ja-images/<?= $currentGrade ?>_active_4x.png" alt="" style="width: 30px;height: 30px;"/>
                                </div>

                                <div class="text-area">
                                    <div class="jp-text" style="margin-bottom: -10px;">課題</div>
                                    <div class="en-text">GTM Challenges</div>
                                </div>
                            </div>
                            <img src="<?= $fontPath ?>/images/ja-images/down_arrow.png" class="down_arrow">
                            
                        </td>

                        <!-- RIGHT CONTENT -->
                        <td width="70%" valign="top">
                            <!-- GTM CHALLENGES -->
                            <table
                                width="100%"
                                cellspacing="0"
                                cellpadding="8"
                                style="background: #f2f2f2; border-radius: 4px"
                            >
                                <tr>
                                    <td style="padding-left: 20px;">
                                        <table class="list-table" width="100%" cellspacing="0" cellpadding="4">
                                            <?php $hasSelected = false;
                                            foreach ($gtmChallenges as $key => $label) {
                                                $id = (int) filter_var($key, FILTER_SANITIZE_NUMBER_INT);

                                                if (in_array($id, $selectedChallenges)) {
                                                    $hasSelected = true;
                                                    ?>
                                            <tr>
                                                <td class="check"></td>
                                                <td style="padding-left: 5px;  font-size: 9px;  line-height: 1.5; color: #24394c; font-weight: bold; padding-top: 0px;">
                                                    <?= htmlspecialchars($label,ENT_QUOTES, 'UTF-8') ?>
                                                </td>
                                            </tr>
                                            <?php } }?>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <!-- BOTTOM -->
                <table class="bottom-table" width="100%" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="30%" valign="top" class="challenge-left">
                            <?php if ($nextGrade): ?>
                            <div class="next-step-box">
                                <div class="icon-circle">
                                    <img src="<?= $fontPath ?>/images/ja-images/<?= $nextGrade ?>_inactive_4x.png" style="width: 45px;height: 40px;" alt="<?= $nextGrade ?>">
                                </div>

                                <div class="text-area">
                                    <div class="jp-text" style="margin-bottom: -10px;">次のステップ</div>
                                    <div class="en-text">Next Actions</div>
                                </div>
                            </div>
                            
                            <?php else: ?>
                            <?php if($grade=='S'){?>
                            <img src="<?= $fontPath ?>/images/ja-images/S_plan_4x.png" alt="S" style="width: 40px;height: 45px;">
                            <div class="jp-text_plain">グレードの維持</div>
                            <div class="text-area" style="margin-top:-25px">
                                <div class="jp-text" style="margin-bottom: -10px;">次のステップ</div>
                                <div class="en-text">Next Actions</div>
                            </div>
                            <?php }?>
                            <?php endif; ?>                            
                        </td>
                        <td width="70%" valign="top">
                            <table class="list-table" width="100%" cellspacing="0" cellpadding="10" style="background: #fff1e6; margin-top: 8px">
                                <?php 

                                    $content = getNextAction($revenue_range,$grade);
                                    if($content): ?>
                                    <tr>
                                        <td style="margin-left: 15px;padding-left: 20px; font-size: 9px; line-height: 1.2; color: #24394c; font-weight: bold;">
                                            
                                            <div style="display:flex; gap:5px; margin-bottom:4px;">
                                                <span style="color:#D85F08; font-weight:bold;">
                                                    優先アクション >
                                                </span>
                                                <span style="color:#24394C; font-weight:bold;">
                                                    <?php echo $content['title'];?>
                                                </span>
                                            </div>

                                            <ul style="margin:0; padding-left:14px; color:#4C4C4C;">
                                                <?php foreach ($content['actions'] as $point): ?>
                                                    <li style="margin-bottom:2px; font-weight:bold; font-family:'NotoSansJP', sans-serif;">
                                                        <?= e($point) ?>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>

                                        </td>
                                    </tr>
                                    <?php endif; ?>
                            </table>
                        </td>
                    </tr>
                </table>

                <table width="100%" cellpadding="0" cellspacing="0" class="footer-section">
                    <tr>
                        <td class="footer-bg">
                            <table width="100%" cellpadding="0" cellspacing="0" style="table-layout: fixed; margin-top: 2px">
                                <tr>
                                    <td width="50%" align="left" valign="middle">
                                        <img src="<?= $fontPath;?>images/people-4x.png" style="width: 100px;margin-top: -30px;"/>
                                    </td>

                                    <td width="50%" align="right" valign="middle">
                                        <img src="<?= $fontPath;?>images/logo-4x.png" style="width: 100px; margin-top: 40px;"/>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>