<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/security.php';
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf($_POST['csrf'] ?? null)) {
        $errors[] = 'Invalid CSRF token';
    }
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
    $password = (string)($_POST['password'] ?? '');
    $stmt = db()->prepare('SELECT id,password_hash FROM users WHERE email=? LIMIT 1');
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password_hash'])) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = (int)$user['id'];
        redirect_to('/dashboard/index.php');
    }
    $errors[] = 'Invalid credentials';
}
include __DIR__ . '/../includes/header.php';
?>
<form method="post" class="max-w-md mx-auto bg-white dark:bg-slate-800 p-6 rounded-xl shadow space-y-4">
  <h1 class="text-2xl font-semibold">Login</h1>
  <?php foreach ($errors as $error): ?><p class="text-red-500"><?= e($error) ?></p><?php endforeach; ?>
  <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
  <input name="email" required type="email" placeholder="Email" class="w-full p-2 rounded border">
  <input name="password" required type="password" placeholder="Password" class="w-full p-2 rounded border">
  <button class="w-full p-2 bg-pink-500 text-white rounded">Login</button>
  <a class="text-sm text-pink-500" href="<?= e(url_for('/auth/forgot_password.php')) ?>">Forgot Password?</a>
</form>
<?php include __DIR__ . '/../includes/footer.php'; ?>
