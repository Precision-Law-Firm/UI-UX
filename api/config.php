
<!-- Infinity Free 
Username : if0_41019850
Password : UUYcwBKabUHO8 -->

<!-- MySQL DB Name	MySQL User Name	MySQL Password	MySQL Host Name	PHPMyAdmin
if0_41019850_plf	if0_41019850	(Your vPanel Password)	sql304.infinityfree.com -->


<?php
// CORS (important pour Vercel)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json");

// DB CONFIG
$host = "sql304.infinityfree.com";
$db   = "if0_41019850_plf";
$user = "if0_41019850";
$pass = "UUYcwBKabUHO8"; 

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$db;charset=utf8mb4",
        $user,
        $pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch (PDOException $e) {
    echo json_encode([
        "success" => false,
        "message" => "Database connection failed"
    ]);
    exit;
}
