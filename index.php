<?php require_once __DIR__ . '/includes/header.php'; ?>
<section class="py-16 md:py-24 grid md:grid-cols-2 gap-10 items-center">
  <div>
    <p class="inline-flex px-3 py-1 rounded-full text-xs bg-pink-100 text-pink-700 mb-4">HIPAA-minded privacy-first experience</p>
    <h1 class="text-4xl md:text-5xl font-bold leading-tight">Professional menstrual health tracking, built for clarity and confidence.</h1>
    <p class="mt-5 text-slate-600 dark:text-slate-300">Track periods, predict upcoming cycles, monitor symptoms, and receive smart reminders through a clean, modern dashboard.</p>
    <div class="mt-8 flex flex-wrap gap-3">
      <a href="<?= e(url_for('/auth/register.php')) ?>" class="px-5 py-3 rounded-xl bg-brand-500 text-white font-medium hover:bg-brand-600 transition">Create Account</a>
      <a href="<?= e(url_for('/auth/login.php')) ?>" class="px-5 py-3 rounded-xl border border-slate-300 dark:border-slate-600 font-medium hover:bg-white/60">Sign In</a>
    </div>
  </div>
  <div class="glass shadow-soft rounded-3xl border border-white/50 dark:border-slate-700 p-6 md:p-8">
    <h2 class="font-semibold text-xl mb-4">Why LunaCycle</h2>
    <ul class="space-y-3 text-sm text-slate-600 dark:text-slate-300">
      <li>• Secure per-user data boundaries with session auth + CSRF controls.</li>
      <li>• Intelligent cycle predictions (next period, fertile window, ovulation).</li>
      <li>• Visual analytics powered by Chart.js for trend awareness.</li>
      <li>• Mobile-responsive and installable PWA-ready architecture.</li>
    </ul>
  </div>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
