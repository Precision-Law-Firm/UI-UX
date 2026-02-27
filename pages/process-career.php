<?php
require '../config.php';
session_start();

// Forcer JSON output
header('Content-Type: application/json');

$response = ['success' => false, 'message' => '', 'errors' => []];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = $_POST['full_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $position = $_POST['position'] ?? '';
    $coverLetter = $_POST['cover_letter'] ?? '';
    $resume = $_FILES['resume'] ?? null;

    $errors = [];
    if (!$fullName || !$email || !$position || !$coverLetter || !$resume) {
        $errors[] = "Please fill all required fields.";
    }

    if ($resume && $resume['error'] === 0) {
        $allowed = ['pdf', 'doc', 'docx'];
        $ext = strtolower(pathinfo($resume['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed)) {
            $errors[] = "Invalid file type. Allowed: PDF, DOC, DOCX.";
        } elseif ($resume['size'] > 5 * 1024 * 1024) {
            $errors[] = "File too large. Max 5MB.";
        } else {
            $uploadDir = __DIR__ . '/../components/cv/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
            $filePath = $uploadDir . uniqid() . '_' . basename($resume['name']);
            move_uploaded_file($resume['tmp_name'], $filePath);
            $resumeRelativePath = 'components/cv/' . basename($filePath);
        }
    }

    if (!empty($errors)) {
        $response['errors'] = $errors;
        echo json_encode($response);
        exit;
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO career_applications 
            (full_name, email, phone, position, cover_letter, resume_path, status, created_at)
            VALUES (?, ?, ?, ?, ?, ?, 'pending', NOW())");
        $stmt->execute([$fullName, $email, $phone, $position, $coverLetter, $resumeRelativePath]);

        $response['success'] = true;
        $response['message'] = "Votre candidature a été soumise avec succès ! Nous reviendrons vers vous sous 5 à 7 jours ouvrables.";
    } catch (Exception $e) {
        $response['errors'][] = $e->getMessage();
    }

    echo json_encode($response);
    exit;
}