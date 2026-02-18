<?php
session_start();
require_once 'config.php';

$loginError = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!$email || !$password) {
        $loginError = 'Email et mot de passe requis.';
    } else {
        try {
            $stmt = $pdo->prepare("SELECT id, email, password, name FROM users WHERE email = :email LIMIT 1");
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch();

            if ($user && $password === $user['password']) { 
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'email' => $user['email'],
                    'name' => $user['name']
                ];
                header('Location: accueil.php');
                exit;
            } else {
                $loginError = 'Email ou mot de passe incorrect.';
            }
        } catch (Exception $e) {
            $loginError = 'Erreur serveur : ' . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Precision Law Firm</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Inter', sans-serif;
      background-color: #f9fafb;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }

    .login-card {
      animation: fadeIn 0.8s ease-out forwards;
      width: 100%;
      max-width: 480px;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .input-field {
      transition: all 0.3s ease;
    }

    .input-field:focus {
      border-color: #1C4D8D;
      box-shadow: 0 0 0 2px rgba(28, 77, 141, 0.1);
    }
  </style>
</head>

<body>
  <div class="login-card">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
      <div class="px-10 py-8 text-center border-b border-gray-100">
        <div class="text-2xl font-bold text-[#0F2854]">Login</div>
      </div>

      <div class="px-10 py-8">

        <!-- Bouton Admin -->
        <div class="mb-6 text-center">
          <a href="admin/index.php"
             class="inline-block bg-gray-700 text-white py-2 px-6 rounded-lg font-medium hover:bg-gray-800 transition duration-300">
             Admin
          </a>
        </div>

        <form method="POST" class="space-y-6">
          <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
            <input type="email" name="email" id="email" required
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none input-field"
              placeholder="Enter your email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
          </div>

          <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
            <div class="relative">
              <input type="password" name="password" id="password" required
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none input-field pr-10"
                placeholder="Enter your password">
              <button type="button" id="togglePassword"
                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                <i class="fas fa-eye"></i>
              </button>
            </div>
          </div>

          <div class="flex items-center justify-between">
            <div class="flex items-center">
              <input type="checkbox" name="remember" id="remember"
                class="h-4 w-4 text-[#1C4D8D] focus:ring-[#1C4D8D] border-gray-300 rounded">
              <label for="remember" class="ml-2 text-sm text-gray-700">Remember me</label>
            </div>
            <a href="#" class="text-sm text-[#1C4D8D] hover:text-[#0F2854]">Forgot password?</a>
          </div>

          <button type="submit"
            class="w-full text-center bg-[#1C4D8D] text-white py-3 px-4 rounded-lg font-medium hover:bg-[#0F2854] transition duration-300">Sign
            In</button>

          <?php if ($loginError) : ?>
          <div
            class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm mt-4 flex items-center">
            <i class="fas fa-exclamation-circle mr-2"></i>
            <span><?= htmlspecialchars($loginError) ?></span>
          </div>
          <?php endif; ?>
        </form>
      </div>
    </div>
  </div>

  <script>
    document.getElementById('togglePassword').addEventListener('click', function () {
      const passwordInput = document.getElementById('password');
      const icon = this.querySelector('i');
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text'; icon.classList.replace('fa-eye', 'fa-eye-slash');
      } else {
        passwordInput.type = 'password'; icon.classList.replace('fa-eye-slash', 'fa-eye');
      }
    });
  </script>
</body>

</html>
