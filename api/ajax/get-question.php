<?php
include '../../inc/session.php';

/* ---------- Language ---------- */
$language = $_SESSION['lang'] ?? 'ja';


/* ---------- Load JSON ---------- */
$data = json_decode(
    file_get_contents(__DIR__ . "/../../lang/$language.json"),
    true
);
function t($key) {
    global $data;
    $parts = explode('.', $key);
    $value = $data;
    foreach ($parts as $p) {
        if (!isset($value[$p])) return $key;
        $value = $value[$p];
    }
    return $value;
}
/* ---------- Decide Question Root by Language ---------- */
if ($language === 'ja') {
    $rootKey = '5w1h';        // Japanese uses 5w1h
} else {
    $rootKey = 'move';        // English uses move
}

/* ---------- Define Question Order ---------- */
/* IMPORTANT: This order must match your UI flow */

if ($language === 'ja') {

    // 5W1H flow (6 questions)
    $questions = [
        ['category'=>'who','key'=>'q1','label'=>t('pdf.categories.who')],
        ['category'=>'where','key'=>'q1','label'=>t('pdf.categories.where')],
        ['category'=>'what','key'=>'q1','label'=>t('pdf.categories.what')],
        ['category'=>'why','key'=>'q1','label'=>t('pdf.categories.why')],
        ['category'=>'how','key'=>'q1','label'=>t('pdf.categories.how')],
        ['category'=>'when','key'=>'q1','label'=>t('pdf.categories.when')],
    ];

} else {

    // MOVE flow (8 questions)
    $questions = [
        ['category'=>'market','key'=>'q1','label'=>'Market'],
        ['category'=>'market','key'=>'q2','label'=>'Market'],

        ['category'=>'operations','key'=>'q1','label'=>'Operations'],
        ['category'=>'operations','key'=>'q2','label'=>'Operations'],

        ['category'=>'velocity','key'=>'q1','label'=>'Velocity'],
        ['category'=>'velocity','key'=>'q2','label'=>'Velocity'],

        ['category'=>'expansion','key'=>'q1','label'=>'Expansion'],
        ['category'=>'expansion','key'=>'q2','label'=>'Expansion'],
    ];
}

$total = count($questions);

/* ---------- Current Index ---------- */
// if (!isset($_SESSION['current_question'])) {
//     $_SESSION['current_question'] = 0;
// }

if (!isset($_SESSION['current_question'])) {

    // If returning from challenges, restore last question
    if (isset($_SESSION['last_question'])) {
        $_SESSION['current_question'] = $_SESSION['last_question'];
    } else {
        $_SESSION['current_question'] = 0;
    }
}

$index = $_SESSION['current_question'];



/* ---------- Finished ---------- */
if ($index >= $total) {

    // Store last valid question index
    $_SESSION['last_question'] = $total - 1;

    echo json_encode(['finished' => true]);
    exit;
}

if(isset($_GET['index'])):
    $index = (int)$_GET['index'];
    $_SESSION['current_question'] =  $index;
endif;

$q = $questions[$index];

/* ---------- Fetch Question Text ---------- */
$questionText = $data[$rootKey]['questions'][$q['category']][$q['key']] ?? null;

if (!$questionText) {
    $questionText = 'Question not found';
}

/* ---------- Existing Answer ---------- */
$answer = $_SESSION['answers'][$index] ?? null;

/* ---------- Response ---------- */
echo json_encode([
    'finished' => false,
    'index'    => $index,
    'total'    => $total,
    'question' => $questionText,
    'category' => $q['label'],
    'answer'   => $answer
]);
