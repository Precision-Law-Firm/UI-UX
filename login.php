<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Methods: POST');

// login.php
header('Content-Type: application/json');
// Autoriser les requêtes depuis n'importe quelle origine (Vercel)
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Methods: POST');

session_start();
require_once 'config.php';

// Récupérer les données JSON envoyées
$data = json_decode(file_get_contents('php://input'), true);

$email = trim($data['email'] ?? '');
$password = $data['password'] ?? '';

if (!$email || !$password) {
    echo json_encode([
        'success' => false,
        'message' => 'Email et mot de passe requis.'
    ]);
    exit;
}

try {
    // Vérification des identifiants
    $stmt = $pdo->prepare("SELECT id, email, password, name FROM users WHERE email = :email LIMIT 1");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if ($user && $password === $user['password']) { // comparaison en clair
        $_SESSION['user'] = [
            'id' => $user['id'],
            'email' => $user['email'],
            'name' => $user['name']
        ];

        echo json_encode([
            'success' => true,
            'user' => $_SESSION['user']
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Email ou mot de passe incorrect.'
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Erreur serveur : ' . $e->getMessage()
    ]);
}
?>
