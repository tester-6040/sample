<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/security.php';
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf($_POST['csrf'] ?? null)) $errors[] = 'Invalid CSRF token';
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
    $password = (string)($_POST['password'] ?? '');
    $name = trim($_POST['name'] ?? '');
    if (!$email || strlen($password) < 8 || $name === '') $errors[] = 'Please enter valid details.';
    if (!$errors) {
        $stmt = db()->prepare('INSERT INTO users (name,email,password_hash,created_at) VALUES (?,?,?,NOW())');
        $stmt->execute([$name, $email, password_hash($password, PASSWORD_DEFAULT)]);
        header('Location: ' . url_for('/auth/login.php') . '?registered=1');
        exit;
    }
}
include __DIR__ . '/../includes/header.php';
?>
<section class="max-w-md mx-auto mt-8">
  <form method="post" class="glass border border-white/60 dark:border-slate-700 rounded-2xl shadow-soft p-7 space-y-4">
    <h1 class="text-2xl font-semibold">Create your account</h1>
    <p class="text-sm text-slate-500">Private, encrypted-signin menstrual cycle tracking.</p>
    <?php foreach ($errors as $error): ?><p class="text-red-500 text-sm"><?= e($error) ?></p><?php endforeach; ?>
    <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
    <input name="name" required placeholder="Full name" class="w-full p-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white/80 dark:bg-slate-900/70">
    <input name="email" required type="email" placeholder="Email" class="w-full p-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white/80 dark:bg-slate-900/70">
    <input name="password" required type="password" placeholder="Password (min 8 chars)" class="w-full p-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white/80 dark:bg-slate-900/70">
    <button class="w-full p-3 bg-brand-500 hover:bg-brand-600 text-white rounded-xl font-medium transition">Register</button>
  </form>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
