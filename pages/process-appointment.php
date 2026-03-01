<?php
require '../config.php';
require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();

header('Content-Type: application/json');

// Désactiver en prod
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'messages' => ['Invalid request method']]);
    exit;
}

/* ================= RÉCUP DATA ================= */

$firstName = trim($_POST['first_name'] ?? '');
$lastName = trim($_POST['last_name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$appointmentDate = trim($_POST['appointment_date'] ?? '');
$appointmentTime = trim($_POST['appointment_time'] ?? '');
$consultationType = trim($_POST['consultation_type'] ?? '');
$attorneyPreference = trim($_POST['attorney_preference'] ?? '');
$caseDescription = trim($_POST['case_description'] ?? '');

/* ================= VALIDATION ================= */

$errors = [];

if (!$firstName) $errors[] = "First Name is required";
if (!$lastName) $errors[] = "Last Name is required";
if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required";
if (!$phone) $errors[] = "Phone is required";
if (!$appointmentDate) $errors[] = "Please select a date";
if (!$appointmentTime) $errors[] = "Please select a time slot";
if (!$consultationType) $errors[] = "Consultation Type is required";

if (!empty($errors)) {
    echo json_encode(['status' => 'error', 'messages' => $errors]);
    exit;
}

try {

    /* ================= TRANSACTION ================= */

    $pdo->beginTransaction();

    // Vérifier disponibilité (verrouillage ligne)
    $stmtCheck = $pdo->prepare("
        SELECT COUNT(*) 
        FROM booked_slots 
        WHERE appointment_date = ? AND time_slot = ?
        FOR UPDATE
    ");
    $stmtCheck->execute([$appointmentDate, $appointmentTime]);
    $count = $stmtCheck->fetchColumn();

    if ($count > 0) {
        $pdo->rollBack();
        echo json_encode([
            'status' => 'error',
            'messages' => ["This time slot is already booked."]
        ]);
        exit;
    }

    // Insérer appointment
    $stmt = $pdo->prepare("
        INSERT INTO appointments 
        (first_name, last_name, email, phone, appointment_date, appointment_time, consultation_type, attorney_preference, case_description, status, created_at, updated_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending', NOW(), NOW())
    ");

    $stmt->execute([
        $firstName, $lastName, $email, $phone,
        $appointmentDate, $appointmentTime,
        $consultationType, $attorneyPreference, $caseDescription
    ]);

    // Bloquer créneau
    $stmt2 = $pdo->prepare("INSERT INTO booked_slots (appointment_date, time_slot) VALUES (?, ?)");
    $stmt2->execute([$appointmentDate, $appointmentTime]);

    $pdo->commit();

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
    $mailAdmin->addReplyTo($email, "$firstName $lastName");

    $mailAdmin->isHTML(true);
    $mailAdmin->Subject = "New Appointment Booking";

    $mailAdmin->Body = "
    <div style='font-family:Arial; padding:20px'>
        <h2 style='color:#1C4D8D;'>New Appointment Request</h2>
        <p><strong>Name:</strong> $firstName $lastName</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>Phone:</strong> $phone</p>
        <p><strong>Date:</strong> $appointmentDate</p>
        <p><strong>Time:</strong> $appointmentTime</p>
        <p><strong>Consultation:</strong> $consultationType</p>
        <p><strong>Attorney:</strong> $attorneyPreference</p>
        <hr>
        <p><strong>Case Description:</strong><br>$caseDescription</p>
    </div>
    ";

    $mailAdmin->send();

    /* ================= EMAIL CLIENT ================= */

    $mailClient = new PHPMailer(true);
    $mailClient->isSMTP();
    $mailClient->Host       = 'smtp.hostinger.com';
    $mailClient->SMTPAuth   = true;
    $mailClient->Username   = 'contact@precisionlawfirm.net';
    $mailClient->Password   = '6H9[=6T#v';
    $mailClient->SMTPSecure = 'tls';
    $mailClient->Port       = 587;

    $mailClient->setFrom('contact@precisionlawfirm.net', 'Precision Law Firm');
    $mailClient->addAddress($email, "$firstName $lastName");

    $mailClient->isHTML(true);
    $mailClient->Subject = "Appointment Request Received ✔";

    $mailClient->Body = "
    <div style='font-family:Arial; padding:20px'>
        <h2 style='color:#1C4D8D;'>Hello $firstName 👋</h2>
        <p>We have received your appointment request.</p>
        <p><strong>Date:</strong> $appointmentDate</p>
        <p><strong>Time:</strong> $appointmentTime</p>
        <p><strong>Consultation:</strong> $consultationType</p>
        <br>
        <p>Our team will contact you soon to confirm.</p>
        <br>
        <p style='color:#888;'>Precision Law Firm</p>
    </div>
    ";

    $mailClient->send();

    echo json_encode([
        'status' => 'success',
        'message' => 'Appointment successfully booked! Confirmation email sent.'
    ]);

} catch (Exception $e) {

    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo json_encode([
        'status' => 'error',
        'messages' => ['Error: ' . $e->getMessage()]
    ]);
}