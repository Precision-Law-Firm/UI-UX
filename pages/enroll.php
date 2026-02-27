<?php
require '../config.php'; 

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Sécurisation basique
        $course_id = intval($_POST['course_id']);
        $name = trim($_POST['student_name']);
        $email = trim($_POST['student_email']);
        $phone = trim($_POST['student_phone']);
        $background = trim($_POST['student_background']);
        $additional = trim($_POST['additional_info'] ?? '');

        if (!$course_id || !$name || !$email || !$phone || !$background) {
            throw new Exception("Missing required fields.");
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

        // Insertion
        $stmt = $pdo->prepare("
            INSERT INTO enrollments 
            (application_code, course_id, course_name, student_name, student_email, student_phone, student_background, additional_info)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->execute([
            $applicationCode,
            $course_id,
            $course_name,  // <-- ici on stocke le nom du cours
            $name,
            $email,
            $phone,
            $background,
            $additional
        ]);

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