<?php
header('Content-Type: application/json');
include("database.php");

$response = ['success' => false];

if (!isset($_POST['id'], $_POST['mode'])) {
    echo json_encode($response);
    exit;
}

$id = $_POST['id'];
$mode = $_POST['mode'];

if (!in_array($mode, ['income', 'expense'], true)) {
    echo json_encode($response);
    exit;
}

$sql = "DELETE FROM $mode WHERE id = :id";
$stmt = $pdo->prepare($sql);
$result = $stmt->execute(['id' => $id]);

$response['success'] = $result && $stmt->rowCount() > 0;
echo json_encode($response);
