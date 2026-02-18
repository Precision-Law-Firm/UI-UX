<?php
session_start();
require_once '../config.php'; // Connexion PDO

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login']); // peut être name ou email
    $password = $_POST['password'];

    if (!empty($login) && !empty($password)) {
        // Vérifie si login correspond à name ou email
        $stmt = $pdo->prepare("SELECT * FROM users WHERE name = ? OR email = ?");
        $stmt->execute([$login, $login]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin && $password === $admin['password']) {
            // Login réussi
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_name'] = $admin['name'];
            header('Location: accueil.php');
            exit;
        } else {
            $error = "Nom d'utilisateur/email ou mot de passe incorrect";
        }
    } else {
        $error = "Veuillez remplir tous les champs";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

<div class="bg-white p-10 rounded-xl shadow-md w-full max-w-md">
    <h2 class="text-2xl font-bold mb-6 text-center">Admin Login</h2>

    <?php if ($error): ?>
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-center"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="post" action="">
        <div class="mb-4">
            <label class="block text-gray-700 mb-2" for="login">Nom d'utilisateur ou Email</label>
            <input type="text" name="login" id="login" class="w-full p-3 border rounded" required>
        </div>
        <div class="mb-6">
            <label class="block text-gray-700 mb-2" for="password">Mot de passe</label>
            <input type="password" name="password" id="password" class="w-full p-3 border rounded" required>
        </div>
        <button type="submit" class="w-full bg-blue-800 text-white p-3 rounded hover:bg-blue-700 transition">Se connecter</button>
    </form>
</div>

</body>
</html>
