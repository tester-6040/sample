<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/security.php';
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf($_POST['csrf'] ?? null)) $errors[] = 'Invalid CSRF token';
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
<section class="max-w-md mx-auto mt-8">
  <form method="post" class="glass border border-white/60 dark:border-slate-700 rounded-2xl shadow-soft p-7 space-y-4">
    <h1 class="text-2xl font-semibold">Welcome back</h1>
    <p class="text-sm text-slate-500">Sign in to your private health dashboard.</p>
    <?php foreach ($errors as $error): ?><p class="text-red-500 text-sm"><?= e($error) ?></p><?php endforeach; ?>
    <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
    <input name="email" required type="email" placeholder="Email" class="w-full p-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white/80 dark:bg-slate-900/70">
    <input name="password" required type="password" placeholder="Password" class="w-full p-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white/80 dark:bg-slate-900/70">
    <button class="w-full p-3 bg-brand-500 hover:bg-brand-600 text-white rounded-xl font-medium transition">Login</button>
    <a class="text-sm text-brand-600" href="<?= e(url_for('/auth/forgot_password.php')) ?>">Forgot Password?</a>
  </form>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
