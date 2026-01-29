<?php
// config.php - Connexion à la base Alwaysdata

// Infos Alwaysdata
define('DB_HOST', 'mysql-precisionlawfirm.alwaysdata.net');  // Host Alwaysdata
define('DB_NAME', 'precisionlawfirm_db');                    // Nom de la base
define('DB_USER', 'precisionlawfirm');                      // Nom d'utilisateur
define('DB_PASS', 'pomVet-xohje5-kanniq');                  // Mot de passe

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
