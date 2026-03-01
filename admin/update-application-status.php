<?php
require '../config.php';
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['admin_logged_in'])) {
    echo json_encode(['success' => false]);
    exit;
}

$id = $_POST['id'] ?? null;
$status = $_POST['status'] ?? null;

$allowed = ['pending', 'reviewed', 'accepted', 'rejected'];

if (!$id || !in_array($status, $allowed)) {
    echo json_encode(['success' => false]);
    exit;
}

$stmt = $pdo->prepare("UPDATE career_applications SET status = ?, updated_at = NOW() WHERE id = ?");
$stmt->execute([$status, $id]);

echo json_encode(['success' => true]);