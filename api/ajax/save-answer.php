<?php
session_start();

/* ---------- Init ---------- */
if (!isset($_SESSION['current_question'])) {
    $_SESSION['current_question'] = 0;
}

if (!isset($_SESSION['answers'])) {
    $_SESSION['answers'] = [];
}

$language = $_SESSION['lang'] ?? 'ja';
$_SESSION['total_questions'] = ($language === 'ja') ? 6 : 8;

$action = $_POST['action'] ?? null;
$answer = $_POST['answer'] ?? null;
$current = $_SESSION['current_question'];
$total   = $_SESSION['total_questions'];


/* ---------- Restore ---------- */
if ($action === 'restore') {
    $restoreIndex = (int) ($_POST['index'] ?? 0);
    if ($restoreIndex < 0) {
        $restoreIndex = 0;
    }
    if ($restoreIndex > $total - 1) {
        $restoreIndex = $total - 1;
    }
    $_SESSION['current_question'] = $restoreIndex;
    echo json_encode(['status'=>'restored']);
    exit;
}


/* ---------- Save Answer ---------- */
if ($answer !== null) {
    $_SESSION['answers'][$current] = (int)$answer;
}


/* ---------- NEXT ---------- */
if ($action === 'next') {

    // Only allow next if current question answered
    if (isset($_SESSION['answers'][$current])) {

        if ($_SESSION['current_question'] < $total) {
            $_SESSION['current_question']++;
        }
    }
}


/* ---------- BACK ---------- */
if ($action === 'back') {

    if ($current > 0) {
        $_SESSION['current_question']--;
    }
}


/* ---------- JUMP ---------- */
if ($action === 'jump') {

    $jumpIndex = (int)$_POST['index'];

    $canJump = true;

    for ($i = 0; $i < $jumpIndex; $i++) {
        if (!isset($_SESSION['answers'][$i])) {
            $canJump = false;
            break;
        }
    }

    if ($canJump && $jumpIndex < $total) {
        $_SESSION['current_question'] = $jumpIndex;
    }
}

/* ---------- Response ---------- */
echo json_encode([
    'status' => 'ok',
    'current' => $_SESSION['current_question']
]);
