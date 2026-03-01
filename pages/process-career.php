<?php
require '../config.php';
require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();

header('Content-Type: application/json');

$response = ['success' => false, 'message' => '', 'errors' => []];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $fullName = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $position = trim($_POST['position'] ?? '');
    $coverLetter = trim($_POST['cover_letter'] ?? '');
    $resume = $_FILES['resume'] ?? null;

    $errors = [];

    /* ================= VALIDATION ================= */

    if (!$fullName || !$email || !$position || !$coverLetter || !$resume) {
        $errors[] = "Please fill all required fields.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
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
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $uniqueName = uniqid() . '_' . preg_replace("/[^a-zA-Z0-9.]/", "_", $resume['name']);
            $filePath = $uploadDir . $uniqueName;

            move_uploaded_file($resume['tmp_name'], $filePath);

            $resumeRelativePath = 'components/cv/' . $uniqueName;
        }
    }

    if (!empty($errors)) {
        $response['errors'] = $errors;
        echo json_encode($response);
        exit;
    }

    try {

        /* ================= INSERT DATABASE ================= */

        $stmt = $pdo->prepare("
            INSERT INTO career_applications 
            (full_name, email, phone, position, cover_letter, resume_path, status, created_at)
            VALUES (?, ?, ?, ?, ?, ?, 'pending', NOW())
        ");

        $stmt->execute([
            $fullName,
            $email,
            $phone,
            $position,
            $coverLetter,
            $resumeRelativePath
        ]);

        /* ================= EMAIL ADMIN ================= */

        $mailAdmin = new PHPMailer(true);

        $mailAdmin->isSMTP();
        $mailAdmin->Host       = 'smtp.hostinger.com';
        $mailAdmin->SMTPAuth   = true;
        $mailAdmin->Username   = 'contact@precisionlawfirm.net';
        $mailAdmin->Password   = '6H9[=6T#v';
        $mailAdmin->SMTPSecure = 'tls';
        $mailAdmin->Port       = 587;

        $mailAdmin->setFrom('contact@precisionlawfirm.net', 'Precision Law Firm');
        $mailAdmin->addAddress('contact@precisionlawfirm.net');
        $mailAdmin->addReplyTo($email, $fullName);

        // Attacher le CV
        $mailAdmin->addAttachment($filePath);

        $mailAdmin->isHTML(true);
        $mailAdmin->Subject = "New Career Application - $position";

        $mailAdmin->Body = "
            <div style='font-family:Arial; padding:20px'>
                <h2 style='color:#1C4D8D;'>New Career Application</h2>
                <p><strong>Name:</strong> $fullName</p>
                <p><strong>Email:</strong> $email</p>
                <p><strong>Phone:</strong> $phone</p>
                <p><strong>Position Applied:</strong> $position</p>
                <hr>
                <p><strong>Cover Letter:</strong><br>$coverLetter</p>
            </div>
        ";

        $mailAdmin->send();

        /* ================= EMAIL CANDIDATE ================= */

        $mailUser = new PHPMailer(true);

        $mailUser->isSMTP();
        $mailUser->Host       = 'smtp.hostinger.com';
        $mailUser->SMTPAuth   = true;
        $mailUser->Username   = 'contact@precisionlawfirm.net';
        $mailUser->Password   = '6H9[=6T#v';
        $mailUser->SMTPSecure = 'tls';
        $mailUser->Port       = 587;

        $mailUser->setFrom('contact@precisionlawfirm.net', 'Precision Law Firm');
        $mailUser->addAddress($email, $fullName);

        $mailUser->isHTML(true);
        $mailUser->Subject = "Application Received ✔";

        $mailUser->Body = "
            <div style='font-family:Arial; padding:20px'>
                <h2 style='color:#1C4D8D;'>Hello $fullName 👋</h2>
                <p>Thank you for applying for the position of <strong>$position</strong>.</p>
                <p>We have received your application successfully.</p>
                <p>Our HR team will review it and contact you within 5 to 7 working days.</p>
                <br>
                <p style='color:#888;'>Precision Law Firm</p>
            </div>
        ";

        $mailUser->send();

        $response['success'] = true;
        $response['message'] = "Votre candidature a été soumise avec succès ! Nous reviendrons vers vous sous 5 à 7 jours ouvrables.";

    } catch (Exception $e) {

        $response['errors'][] = "Error: " . $e->getMessage();
    }

    echo json_encode($response);
    exit;
}