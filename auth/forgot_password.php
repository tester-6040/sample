<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/security.php';
$message='';
if ($_SERVER['REQUEST_METHOD']==='POST' && verify_csrf($_POST['csrf'] ?? null)) {
  $email=filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
  if ($email) {
    $token=bin2hex(random_bytes(24));
    $stmt=db()->prepare('UPDATE users SET reset_token=?,reset_expires=DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE email=?');
    $stmt->execute([$token,$email]);
    $message='Password reset link: '.BASE_URL.url_for('/auth/reset_password.php').'?token='.$token;
  }
}
include __DIR__.'/../includes/header.php'; ?>
<form method="post" class="max-w-md mx-auto bg-white p-6 rounded-xl shadow space-y-4"><h1>Forgot Password</h1><input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>"><input name="email" type="email" class="w-full p-2 border rounded" required><button class="w-full p-2 bg-pink-500 text-white rounded">Send reset link</button><p class="text-sm"><?= e($message) ?></p></form>
<?php include __DIR__.'/../includes/footer.php';
