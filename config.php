<?php
// config.php - Connexion à la base Alwaysdata
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Methods: POST');

// Infos Alwaysdata
define('DB_HOST', 'mysql-precisionlawfirm.alwaysdata.net');  
define('DB_NAME', 'precisionlawfirm_db');                    
define('DB_USER', 'precisionlawfirm');                     
define('DB_PASS', 'pomVet-xohje5-kanniq');                  

try {
    $pdo = new PDO(
        "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch (PDOException $e) {
    die("Erreur de connexion à la base : " . $e->getMessage());
}
?>
