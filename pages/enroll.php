<?php
require '../config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    try {
        // Sécurisation
        $course_id = intval($_POST['course_id']);
        $name = trim($_POST['student_name']);
        $email = trim($_POST['student_email']);
        $phone = trim($_POST['student_phone']);
        $background = trim($_POST['student_background']);
        $additional = trim($_POST['additional_info'] ?? '');

        if (!$course_id || !$name || !$email || !$phone || !$background) {
            throw new Exception("Missing required fields.");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email address.");
        }

        // Récupérer le nom du cours
        $stmtCourse = $pdo->prepare("SELECT title FROM courses WHERE id = ?");
        $stmtCourse->execute([$course_id]);
        $course = $stmtCourse->fetch();

        if (!$course) {
            throw new Exception("Course not found.");
        }

        $course_name = $course['title'];

        // Génération ID candidature
        $applicationCode = 'STU-' . strtoupper(substr(uniqid(), -4));

        // Insertion BDD
        $stmt = $pdo->prepare("
            INSERT INTO enrollments 
            (application_code, course_id, course_name, student_name, student_email, student_phone, student_background, additional_info)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->execute([
            $applicationCode,
            $course_id,
            $course_name,
            $name,
            $email,
            $phone,
            $background,
            $additional
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

        $mailAdmin->isHTML(true);
        $mailAdmin->Subject = "New Enrollment - $course_name";

        $mailAdmin->Body = "
            <h2>New Course Enrollment</h2>
            <p><strong>Application Code:</strong> $applicationCode</p>
            <p><strong>Course:</strong> $course_name</p>
            <p><strong>Name:</strong> $name</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Phone:</strong> $phone</p>
            <p><strong>Background:</strong> $background</p>
            <p><strong>Additional Info:</strong> $additional</p>
        ";

        $mailAdmin->send();

        /* ================= EMAIL STUDENT ================= */

        $mailStudent = new PHPMailer(true);
        $mailStudent->isSMTP();
        $mailStudent->Host       = 'smtp.hostinger.com';
        $mailStudent->SMTPAuth   = true;
        $mailStudent->Username   = 'contact@precisionlawfirm.net';
        $mailStudent->Password   = '6H9[=6T#v';
        $mailStudent->SMTPSecure = 'tls';
        $mailStudent->Port       = 587;

        $mailStudent->setFrom('contact@precisionlawfirm.net', 'Precision Law Firm');
        $mailStudent->addAddress($email, $name);

        $mailStudent->isHTML(true);
        $mailStudent->Subject = "Application Received - $course_name";

        $mailStudent->Body = "
            <h2>Hello $name </h2>
            <p>Thank you for applying to <strong>$course_name</strong>.</p>
            <p>Your application code is:</p>
            <h3 style='color:#1C4D8D;'>$applicationCode</h3>
            <p>We will review your application and contact you soon.</p>
            <br>
            <p>Best regards,<br>Precision Law Firm Team</p>
        ";

        $mailStudent->send();

        /* ========================================= */

        echo json_encode([
            'success' => true,
            'applicationCode' => $applicationCode,
            'courseName' => $course_name
        ]);
        exit;

    } catch (Exception $e) {

        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
        exit;
    }
}

echo json_encode([
    'success' => false,
    'message' => 'Invalid request.'
]);