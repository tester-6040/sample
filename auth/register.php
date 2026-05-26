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
    $name = trim($_POST['name'] ?? '');

    if (!$email || strlen($password) < 8 || $name === '') {
        $errors[] = 'Please enter valid details.';
    }

    if (!$errors) {
        $stmt = db()->prepare('INSERT INTO users (name,email,password_hash,created_at) VALUES (?,?,?,NOW())');
        $stmt->execute([$name, $email, password_hash($password, PASSWORD_DEFAULT)]);
        header('Location: ' . url_for('/auth/login.php') . '?registered=1');
        exit;
    }
}
include __DIR__ . '/../includes/header.php';
?>
<form method="post" class="max-w-md mx-auto bg-white dark:bg-slate-800 p-6 rounded-xl shadow space-y-4">
  <h1 class="text-2xl font-semibold">Create account</h1>
  <?php foreach ($errors as $error): ?><p class="text-red-500"><?= e($error) ?></p><?php endforeach; ?>
  <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
  <input name="name" required placeholder="Name" class="w-full p-2 rounded border">
  <input name="email" required type="email" placeholder="Email" class="w-full p-2 rounded border">
  <input name="password" required type="password" placeholder="Password" class="w-full p-2 rounded border">
  <button class="w-full p-2 bg-pink-500 text-white rounded">Register</button>
</form>
<?php include __DIR__ . '/../includes/footer.php'; ?>
