<?php
require_once __DIR__ . '/security.php';
require_once __DIR__ . '/lang.php';
require_once __DIR__ . '/url.php';
?>
<!doctype html>
<html lang="<?= e(get_lang()) ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= e(APP_NAME) ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link rel="manifest" href="<?= e(url_for('/assets/manifest.json')) ?>">
</head>
<body data-base-path="<?= e(base_path()) ?>" class="bg-pink-50 text-slate-800 dark:bg-slate-900 dark:text-slate-100 min-h-screen">
<nav class="bg-white/80 dark:bg-slate-800/80 backdrop-blur border-b border-pink-100 p-4 flex justify-between">
  <a href="<?= e(url_for('/')) ?>" class="font-bold text-pink-600">🌙 <?= e(APP_NAME) ?></a>
  <div class="space-x-4">
    <?php if (!empty($_SESSION['user_id'])): ?>
      <a href="<?= e(url_for('/dashboard/index.php')) ?>"><?= e(t('dashboard')) ?></a>
      <a href="<?= e(url_for('/auth/logout.php')) ?>"><?= e(t('logout')) ?></a>
    <?php else: ?>
      <a href="<?= e(url_for('/auth/login.php')) ?>"><?= e(t('login')) ?></a>
      <a href="<?= e(url_for('/auth/register.php')) ?>"><?= e(t('register')) ?></a>
    <?php endif; ?>
  </div>
</nav>
<main class="max-w-6xl mx-auto p-4">
