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
  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          colors: { brand: { 500: '#ec4899', 600: '#db2777' } },
          boxShadow: { soft: '0 10px 35px -15px rgba(15,23,42,0.35)' }
        }
      }
    }
  </script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link rel="stylesheet" href="<?= e(url_for('/assets/css/theme.css')) ?>">
  <link rel="manifest" href="<?= e(url_for('/assets/manifest.json')) ?>">
</head>
<body data-base-path="<?= e(base_path()) ?>" class="soft-gradient text-slate-800 dark:text-slate-100 min-h-screen antialiased">
<nav class="sticky top-0 z-20 backdrop-blur border-b border-slate-200/70 dark:border-slate-700/70 bg-white/70 dark:bg-slate-900/70">
  <div class="max-w-6xl mx-auto p-4 flex justify-between items-center">
    <a href="<?= e(url_for('/')) ?>" class="font-bold text-brand-600 text-xl tracking-tight">LunaCycle</a>
    <div class="space-x-5 text-sm font-medium">
      <?php if (!empty($_SESSION['user_id'])): ?>
        <a class="hover:text-brand-600" href="<?= e(url_for('/dashboard/index.php')) ?>"><?= e(t('dashboard')) ?></a>
        <a class="hover:text-brand-600" href="<?= e(url_for('/auth/logout.php')) ?>"><?= e(t('logout')) ?></a>
      <?php else: ?>
        <a class="hover:text-brand-600" href="<?= e(url_for('/auth/login.php')) ?>"><?= e(t('login')) ?></a>
        <a class="inline-flex px-4 py-2 rounded-xl bg-brand-500 text-white hover:bg-brand-600 transition" href="<?= e(url_for('/auth/register.php')) ?>"><?= e(t('register')) ?></a>
      <?php endif; ?>
    </div>
  </div>
</nav>
<main class="max-w-6xl mx-auto p-4 md:p-6">
