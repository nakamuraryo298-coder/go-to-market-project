<?php
// session_start();
require_once __DIR__ . '/env.php';

/*
|--------------------------------------------------------------------------
| Base Configuration
|--------------------------------------------------------------------------
*/
// define('BASE_URL', 'https://gotomarketfrontend.rewainfotech.com');
if (!function_exists('detectBaseUrl')) {
    function detectBaseUrl()
    {
        $configuredBaseUrl = function_exists('env') ? (string) env('BASE_URL', '') : (string) getenv('BASE_URL');
        $appEnv = function_exists('env') ? (string) env('APP_ENV', 'development') : 'development';
        if ($configuredBaseUrl !== '' && $appEnv !== 'development') {
            return rtrim($configuredBaseUrl, '/');
        }

        if (PHP_SAPI === 'cli') {
            return 'https://go-to-market.jp';
        }

        $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        if (!empty($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
            $forwardedProto = explode(',', $_SERVER['HTTP_X_FORWARDED_PROTO']);
            $scheme = trim($forwardedProto[0]);
        }

        $rawHost = $_SERVER['HTTP_X_FORWARDED_HOST'] ?? ($_SERVER['HTTP_HOST'] ?? 'go-to-market.jp');
        $host = trim(explode(',', $rawHost)[0]);

        $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
        $basePath = (strpos($scriptName, '/projects/gotomarket-site/') === 0) ? '/projects/gotomarket-site' : '';

        return $scheme . '://' . $host . $basePath;
    }
}

define('BASE_URL', detectBaseUrl());

$supportedLanguages = ['ja', 'en'];
$defaultLanguage = 'ja';

/*
|--------------------------------------------------------------------------
| Language Detection (URL > Session > Browser > Default)
|--------------------------------------------------------------------------
*/
function detectLanguage()
{
    global $supportedLanguages, $defaultLanguage;

    if (isset($_GET['lang']) && in_array($_GET['lang'], $supportedLanguages)) {
        $_SESSION['lang'] = $_GET['lang'];
        return $_GET['lang'];
    }

    if (isset($_SESSION['lang']) && in_array($_SESSION['lang'], $supportedLanguages)) {
        return $_SESSION['lang'];
    }

    $browserLang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '', 0, 2);
    if (in_array($browserLang, $supportedLanguages)) {
        return $browserLang;
    }

    return $defaultLanguage;
}

function currentUrl()
{
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
    $host     = $_SERVER['HTTP_HOST'];
    $uri      = $_SERVER['REQUEST_URI'];

    return $protocol . "://" . $host . $uri;
}

function getLastUriSegment($url = null)
{
    if ($url === null) {
        $url = $_SERVER['REQUEST_URI'];
    }

    $path = parse_url($url, PHP_URL_PATH);
    $segments = array_values(array_filter(explode('/', $path)));

    return end($segments);
}

/*
|--------------------------------------------------------------------------
| Load JSON Translations
|--------------------------------------------------------------------------
*/
function loadTranslations($lang)
{
    $file = __DIR__ . "/../lang/{$lang}.json";

    if (!file_exists($file)) {
        die("Language file not found: {$lang}");
    }

    $data = json_decode(file_get_contents($file), true);

    if (!$data) {
        die("Invalid JSON in {$lang}.json");
    }

    return $data;
}

/*
|--------------------------------------------------------------------------
| Translation Helper
|--------------------------------------------------------------------------
*/
// function __($key)
// {
//     global $translations;

//     $keys = explode('.', $key);
//     $value = $translations;

//     foreach ($keys as $k) {
//         if (!isset($value[$k])) return $key;
//         $value = $value[$k];
//     }

//     return $value;
// }

/*
|--------------------------------------------------------------------------
| Generate Language URLs
|--------------------------------------------------------------------------
*/
function langUrl($lang)
{
    $page = $_GET['page'] ?? '';
    return BASE_URL . '/' . $lang . '/' . trim($page, '/');
}

/*
|--------------------------------------------------------------------------
| Generate Page URLs
|--------------------------------------------------------------------------
*/
function url($path = '')
{
    return BASE_URL . '/' . ltrim($path, '/');
}

/*
|--------------------------------------------------------------------------
| Asset Helper
|--------------------------------------------------------------------------
*/
function asset($path)
{
    return BASE_URL . '/' . ltrim($path, '/');
}

function versionedAsset($path)
{
    $relativePath = ltrim($path, '/');
    $assetUrl = BASE_URL . '/' . $relativePath;
    $assetFile = __DIR__ . '/../' . $relativePath;

    if (!is_file($assetFile)) {
        return $assetUrl;
    }

    return $assetUrl . '?v=' . filemtime($assetFile);
}

if(!function_exists('blockedDomains')){
   function blockedDomains(){
        $blockedDomains = [
            "gmail.com",
            "yahoo.com",
            "outlook.com",
            "hotmail.com",
            "live.com",
            "msn.com",
            "aol.com",
            "icloud.com",
            "me.com",
            "mac.com",
            "yandex.com",
            "mail.ru",
            "protonmail.com",
            "tutanota.com",
        ];
        return $blockedDomains;
   }
}

if(!function_exists('revenueOptions')){
    function revenueOptions($language=''){
        if($language=='en'){
            $revenueOptions = [
                "smb" => "SMB (Small & Growing): Under $10M",
                "mid-market" => "Mid-market (Scaling): $10M–$1B",
                "enterprise" => "Enterprise (Global / Large-scale): Over $1B"
            ];
        }else{
            $revenueOptions = [
                "under-100m" => "1億円未満 / Under ¥100M",
                "under-1b" => "10億円未満 / Under ¥1B",
                "1b-5b" => "10〜50億円 / ¥1B〜¥5B",
                "5b-10b" => "50〜100億円 / ¥5B〜¥10B",
                "over-10b" => "100億円以上 / Over ¥10B"
            ];
        }
        
        return $revenueOptions;
    }
}
if (!function_exists('departmentOptions')) {
    function departmentOptions($language = '')
    {
        if ($language === 'en') {
            $departmentOptions = [
                'sales'     => 'Sales Department',
                'marketing' => 'Marketing Department',
                'business'  => 'Business Development Department',
                'planning'  => 'Corporate Planning Department',
                'other'     => 'Other',
            ];
        } else {
            $departmentOptions = [
                'sales'     => '営業部門 / Sales Department',
                'marketing' => 'マーケティング部門 / Marketing Department',
                'business'  => '事業開発部門 / Business Development Department',
                'planning'  => '経営企画部門 / Corporate Planning Department',
                'other'     => 'その他 / Other',
            ];
        }

        return $departmentOptions;
    }
}
if (!function_exists('jobTitleOptions')) {
    function jobTitleOptions($language = '')
    {
        if ($language === 'en') {
            $jobTitleOptions = [
                'staff'    => 'Staff',
                'manager'  => 'Manager',
                'director' => 'Director',
                'vp'       => 'VP',
                'cxo'      => 'CxO / Executive',
            ];
        } else {
            $jobTitleOptions = [
                'staff'    => '担当者 / Staff',
                'manager'  => '課長 / Manager',
                'director' => '部長 / Director',
                'vp'       => '本部長・役員クラス / VP',
                'cxo'      => '経営層（CxO, CEO, COO, CFO, CMOなど） / CxO / Executive',
            ];
        }

        return $jobTitleOptions;
    }
}
function getQuestions($lang = 'en')
{
    if ($lang === 'ja') {
        return [
            ['id'=>1,'text'=>'move.questions.market.q1','category'=>'Market'],
            ['id'=>2,'text'=>'move.questions.market.q2','category'=>'Market'],
            ['id'=>3,'text'=>'move.questions.operations.q1','category'=>'Operations'],
            ['id'=>4,'text'=>'move.questions.operations.q2','category'=>'Operations'],
            ['id'=>5,'text'=>'move.questions.velocity.q1','category'=>'Velocity'],
            ['id'=>6,'text'=>'move.questions.velocity.q2','category'=>'Velocity'],
            ['id'=>7,'text'=>'move.questions.expansion.q1','category'=>'Expansion'],
            ['id'=>8,'text'=>'move.questions.expansion.q2','category'=>'Expansion'],
        ];
    }

    // English (same keys, text from en.json)
    return [
        ['id'=>1,'text'=>'move.questions.market.q1','category'=>'Market'],
        ['id'=>2,'text'=>'move.questions.market.q2','category'=>'Market'],
        ['id'=>3,'text'=>'move.questions.operations.q1','category'=>'Operations'],
        ['id'=>4,'text'=>'move.questions.operations.q2','category'=>'Operations'],
        ['id'=>5,'text'=>'move.questions.velocity.q1','category'=>'Velocity'],
        ['id'=>6,'text'=>'move.questions.velocity.q2','category'=>'Velocity'],
        ['id'=>7,'text'=>'move.questions.expansion.q1','category'=>'Expansion'],
        ['id'=>8,'text'=>'move.questions.expansion.q2','category'=>'Expansion'],
    ];
}
