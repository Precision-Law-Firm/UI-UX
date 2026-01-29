<?php
header('Content-Type: application/json');
session_start();
require_once 'config.php';

$data = json_decode(file_get_contents('php://input'), true);

$email = trim($data['email'] ?? '');
$password = $data['password'] ?? '';

if (!$email || !$password) {
    echo json_encode(['success'=>false,'message'=>'Email et mot de passe requis.']);
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT id, email, password, name FROM users WHERE email = :email LIMIT 1");
    $stmt->execute(['email'=>$email]);
    $user = $stmt->fetch();

    if ($user && $password === $user['password']) {
        $_SESSION['user'] = ['id'=>$user['id'],'email'=>$user['email'],'name'=>$user['name']];
        echo json_encode(['success'=>true,'user'=>$_SESSION['user']]);
    } else {
        echo json_encode(['success'=>false,'message'=>'Email ou mot de passe incorrect.']);
    }
} catch (Exception $e) {
    echo json_encode(['success'=>false,'message'=>'Erreur serveur : '.$e->getMessage()]);
}
?>
