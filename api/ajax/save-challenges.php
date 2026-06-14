<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');

if (!isset($_POST['challenges'])) {
    echo json_encode(['status'=>false]);
    exit;
}

$data = json_decode($_POST['challenges'], true);

if (!is_array($data)) {
    echo json_encode(['status'=>false]);
    exit;
}

$_SESSION['selected_challenges'] = $data;

/* Force session write */
session_write_close();

echo json_encode(['status'=>true]);
