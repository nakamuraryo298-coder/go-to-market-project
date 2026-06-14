<?php
include '../inc/session.php';
require_once '../config/db.php';
require_once '../config/helpers.php';

header('Content-Type: application/json');

/* ---------------- Security Headers ---------------- */
header("X-XSS-Protection: 1; mode=block");
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: SAMEORIGIN");

/* ---------------- Block Large Payload ---------------- */
if (!empty($_SERVER['CONTENT_LENGTH']) && $_SERVER['CONTENT_LENGTH'] > 51200) {
    echo json_encode([
        'success' => false,
        'message' => 'Request too large'
    ]);
    exit;
}

/* ---------------- Language ---------------- */
$lang = $_POST['lang'] ?? 'en';
$isAssessmentResume = ($_POST['resumeAssessment'] ?? '') === '1' && !empty($_SESSION['form_data']);

/* ---------------- Messages ---------------- */
$messages = [
    'en' => [
        'lastName'     => 'Last name is required',
        'firstName'    => 'First name is required',
        'email'        => 'Email is required',
        'emailInvalid' => 'Enter a valid email address',
        'emailCompany' => 'Please use your company email address',
        'company'      => 'Company name is required',
        'revenueRange' => 'Revenue range is required',
        'jobTitle'     => 'Job title is required',
        'department'   => 'Department is required',
        'consent'      => 'You must agree to the Terms and Privacy Policy.',
        'marketing_consent'=> 'You must consent to receive updates.',
        'nameInvalid'  => 'Please enter a valid name',
        'maxLength'    => 'Maximum %d characters allowed',
        'success'      => 'Form submitted successfully',
        'email_exists' => 'Email already exists',
    ],
    'ja' => [
        'lastName'     => '姓は必須です',
        'firstName'    => '名は必須です',
        'email'        => 'メールアドレスは必須です',
        'emailInvalid' => '有効なメールアドレスを入力してください',
        'emailCompany' => '会社のメールアドレスを入力してください',
        'company'      => '会社名は必須です',
        'revenueRange' => '売上規模を選択してください',
        'jobTitle'     => '役職を選択してください',
        'department'   => '部署を選択してください',
        'consent'      => '利用規約およびプライバシーポリシーへの同意が必要です',
        'marketing_consent'=> '最新情報の受信への同意が必要です',
        'nameInvalid'  => '正しい名前を入力してください',
        'maxLength'    => '最大 %d 文字まで入力できます',
        'success'      => '送信が完了しました',
        'email_exists' => 'このメールアドレスは既に登録されています'
    ]
];

/* ---------------- Normalize POST ---------------- */
$input = [];
foreach ($_POST as $k => $v) {
    if (is_string($v)) {
        $input[$k] = trim($v);
    }
}

/* ---------------- Max Length Rules ---------------- */
$maxLengths = [
    'firstName'    => 100,
    'lastName'     => 100,
    'email'        => 150,
    'company'      => 150,
    'revenueRange' => 100,
    'jobTitle'     => 150,
    'department'   => 150
];

/* ---------------- Required Fields ---------------- */
$required = [
    'lastName',
    'firstName',
    'email',
    'company',
    'revenueRange',
    'jobTitle',
    'department'
];

$errors = [];

/* ---------------- Max Length Validation ---------------- */

foreach ($maxLengths as $field => $max) {
    if (!empty($input[$field])) {

        if (mb_strlen($input[$field], 'UTF-8') > $max) {

            $errors[$field] = sprintf($messages[$lang]['maxLength'], $max);
        }
    }
}

/* ---------------- Required Validation ---------------- */
foreach ($required as $field) {
    if (empty($input[$field])) {
        $errors[$field] = $messages[$lang][$field];
    }
}


/* ---------------- Name Format Validation ---------------- */

// $namePattern = "/^[a-zA-Z\s'-]+$/u";
$namePattern = "/^[\p{L}\s'-]+$/u";


foreach (['firstName', 'lastName'] as $nameField) {

    // ⭐ Only run if NO previous error
    if (empty($errors[$nameField]) && !empty($input[$nameField])) {

        if (!preg_match($namePattern, $input[$nameField])) {

            $errors[$nameField] = $messages[$lang]['nameInvalid'];
        }
    }
}

$validRevenue   = array_keys(revenueOptions($lang));
$validDept      = array_keys(departmentOptions($lang));
$validJobTitles = array_keys(jobTitleOptions($lang));

if (!empty($input['revenueRange']) && !in_array($input['revenueRange'], $validRevenue, true)) {
    $errors['revenueRange'] = $lang === 'ja'
        ? "無効な値が送信されました"
        : "Invalid value submitted";
}

if (!empty($input['department']) && !in_array($input['department'], $validDept, true)) {
    $errors['department'] = $lang === 'ja'
        ? "無効な値が送信されました"
        : "Invalid value submitted";
}

if (!empty($input['jobTitle']) && !in_array($input['jobTitle'], $validJobTitles, true)) {
    $errors['jobTitle'] = $lang === 'ja'
        ? "無効な値が送信されました"
        : "Invalid value submitted";
}
/* ---------------- Consent ---------------- */
if (empty($input['consent'])) {
    $errors['consent'] = $messages[$lang]['consent'];
}
if(empty($input['marketing_consent'])){
    $errors['marketing_consent'] = $messages[$lang]['marketing_consent'];
}
/* ---------------- Email Validation ---------------- */
/* ---------------- Email Validation ---------------- */

if (!empty($input['email'])) {

    $email = trim($input['email']);

    // Basic format validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $errors['email'] = $messages[$lang]['emailInvalid'];

    } else {

        // Block multiple consecutive dots
        if (preg_match('/\.{2,}/', $email)) {
            $errors['email'] = $messages[$lang]['emailInvalid'];
        }

        // Extract domain
        $domain = strtolower(substr(strrchr($email, "@"), 1));

        // Domain must contain dot
        if (!str_contains($domain, '.')) {
            $errors['email'] = $messages[$lang]['emailInvalid'];
        }

        // Block personal domains
        $blockedDomains = [
            'gmail.com',
            'yahoo.com',
            'hotmail.com',
            'outlook.com',
            'icloud.com'
        ];

        if (in_array($domain, $blockedDomains, true)) {
            $errors['email'] = $messages[$lang]['emailCompany'];
        }

        // MX Record check
        if (!checkdnsrr($domain, "MX")) {
            $errors['email'] = $messages[$lang]['emailInvalid'];
        }
    }
}

/* ---------------- Return Errors ---------------- */
if (!empty($errors)) {
    echo json_encode([
        'success' => false,
        'errors'  => $errors
    ]);
    exit;
}

/* ---------------- Store Session ---------------- */
$_SESSION['form_data'] = [
    'firstName'    => clean_input($input['firstName']),
    'lastName'     => clean_input($input['lastName']),
    'email'        => clean_input($input['email']),
    'company'      => clean_input($input['company']),
    'revenueRange' => clean_input($input['revenueRange']),
    'jobTitle'     => clean_input($input['jobTitle']),
    'department'   => clean_input($input['department']),
    'lang'         => $lang
];

if ($isAssessmentResume) {
    echo json_encode([
        'success' => true,
        'message' => $messages[$lang]['success']
    ]);
    exit;
}

/* ---------------- DB Insert ---------------- */
/* -------- Check Duplicate Email -------- */
$checkSql = "SELECT id FROM form_submissions WHERE email = ?";
$checkStmt = mysqli_prepare($conn, $checkSql);

mysqli_stmt_bind_param(
    $checkStmt,
    "s",
    $input['email']
);

mysqli_stmt_execute($checkStmt);
mysqli_stmt_store_result($checkStmt);

if (mysqli_stmt_num_rows($checkStmt) > 0) {
    echo json_encode([
        'success' => false,
        'errors' => [
            'email' => $messages[$lang]['email_exists']
        ]
    ]);
    exit;
}

mysqli_stmt_close($checkStmt);


/* -------- Insert Data -------- */
$sql = "INSERT INTO form_submissions 
(first_name,last_name,email,company,revenue_range,job_title,department,consent,marketing_consent)
VALUES (?,?,?,?,?,?,?,?,?)";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "sssssssss",
    $input['firstName'],
    $input['lastName'],
    $input['email'],
    $input['company'],
    $input['revenueRange'],
    $input['jobTitle'],
    $input['department'],
    $input['consent'],
    $input['marketing_consent']
);

if (!mysqli_stmt_execute($stmt)) {
    echo json_encode([
        'success' => false,
        'message' => 'Database insert failed'
    ]);
    exit;
}

mysqli_stmt_close($stmt);

echo json_encode([
    'success' => true,
    'message' => $messages[$lang]['success']
]);
