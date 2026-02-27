<?php
require '../config.php';
session_start();

// Activer l'affichage des erreurs pour debug (à désactiver en prod)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Retourner du JSON
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'messages' => ['Invalid request method']]);
    exit;
}

// --- Récupérer les données du formulaire ---
$firstName = trim($_POST['first_name'] ?? '');
$lastName = trim($_POST['last_name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$appointmentDate = trim($_POST['appointment_date'] ?? '');
$appointmentTime = trim($_POST['appointment_time'] ?? '');
$consultationType = trim($_POST['consultation_type'] ?? '');
$attorneyPreference = trim($_POST['attorney_preference'] ?? '');
$caseDescription = trim($_POST['case_description'] ?? '');

// --- Validation ---
$errors = [];
if (!$firstName) $errors[] = "First Name is required";
if (!$lastName) $errors[] = "Last Name is required";
if (!$email) $errors[] = "Email is required";
if (!$phone) $errors[] = "Phone is required";
if (!$appointmentDate) $errors[] = "Please select a date";
if (!$appointmentTime) $errors[] = "Please select a time slot";
if (!$consultationType) $errors[] = "Consultation Type is required";

if (!empty($errors)) {
    echo json_encode(['status' => 'error', 'messages' => $errors]);
    exit;
}

try {
    // Vérifier si le créneau est déjà réservé
    $stmtCheck = $pdo->prepare("SELECT COUNT(*) FROM booked_slots WHERE appointment_date = ? AND time_slot = ?");
    $stmtCheck->execute([$appointmentDate, $appointmentTime]);
    $count = $stmtCheck->fetchColumn();

    if ($count > 0) {
        echo json_encode(['status' => 'error', 'messages' => ["This time slot is already booked. Please select another one."]]);
        exit;
    }

    // --- Insérer dans la table appointments ---
    $stmt = $pdo->prepare("
        INSERT INTO appointments 
        (first_name, last_name, email, phone, appointment_date, appointment_time, consultation_type, attorney_preference, case_description, status, created_at, updated_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending', NOW(), NOW())
    ");
    $stmt->execute([
        $firstName, $lastName, $email, $phone, $appointmentDate, $appointmentTime,
        $consultationType, $attorneyPreference, $caseDescription
    ]);

    // --- Marquer le créneau comme réservé ---
    $stmt2 = $pdo->prepare("INSERT INTO booked_slots (appointment_date, time_slot) VALUES (?, ?)");
    $stmt2->execute([$appointmentDate, $appointmentTime]);

    echo json_encode(['status' => 'success', 'message' => 'Appointment successfully booked! We will contact you to confirm.']);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'messages' => ["Database error: " . $e->getMessage()]]);
}

