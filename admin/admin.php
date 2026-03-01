<?php
require_once '../config.php';

// --- Infos de l'admin ---
$name = 'admin';               
$email = 'lawfirmprecision@outlook.com';    
$password = 'SecuredPass88';   

// --- Hasher le mot de passe ---
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

try {
    // --- Préparer et exécuter l'insert ---
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->execute([$name, $email, $hashedPassword]);

    echo "Admin créé avec succès !";
} catch (PDOException $e) {
    if ($e->getCode() == 23000) { // code erreur duplicate email
        echo "Cet admin existe déjà !";
    } else {
        echo "Erreur : " . $e->getMessage();
    }
}