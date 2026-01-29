<?php
// Toujours en haut
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Methods: POST');

try {
    $pdo = new PDO(
        "mysql:host=localhost;dbname=precisionlawfirm_db;charset=utf8mb4",
        'precisionlawfirm',
        'pomVet-xohje5-kanniq',
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch (PDOException $e) {
    die("Erreur de connexion à la base : " . $e->getMessage());
}
?>
