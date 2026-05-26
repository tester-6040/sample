<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/security.php';
require_once __DIR__ . '/../includes/cycle.php';
require_auth();
$stmt = db()->prepare('SELECT * FROM periods WHERE user_id=? ORDER BY start_date ASC');
$stmt->execute([current_user_id()]);
$periods = $stmt->fetchAll();
$analysis = analyze_cycles($periods);
$healthInsight = $analysis['irregular'] ? 'Cycle variability is elevated this month—prioritize sleep, hydration, and stress control.' : 'Your pattern looks stable based on current entries.';
include __DIR__ . '/../includes/header.php';
?>
<div class="grid lg:grid-cols-3 gap-5">
  <section class="lg:col-span-2 space-y-5">
    <div class="metric-card p-5 shadow-soft">
      <h2 class="text-xl font-semibold">Cycle Intelligence Dashboard</h2>
      <div class="grid sm:grid-cols-3 gap-3 mt-4 text-sm">
        <div class="p-3 rounded-xl bg-pink-50 dark:bg-slate-700"><p class="text-slate-500">Next Period</p><p class="font-semibold"><?= e((string)$analysis['next_period']) ?></p></div>
        <div class="p-3 rounded-xl bg-purple-50 dark:bg-slate-700"><p class="text-slate-500">Ovulation</p><p class="font-semibold"><?= e((string)$analysis['ovulation']) ?></p></div>
        <div class="p-3 rounded-xl bg-indigo-50 dark:bg-slate-700"><p class="text-slate-500">Fertile Window</p><p class="font-semibold"><?= e((string)$analysis['fertile_start']) ?> → <?= e((string)$analysis['fertile_end']) ?></p></div>
      </div>
      <p class="mt-4 text-sm">AI Insight: <span class="text-brand-600 font-medium"><?= e($healthInsight) ?></span></p>
      <canvas id="cycleChart" class="mt-5"></canvas>
    </div>
  </section>
  <aside class="metric-card p-5 shadow-soft h-fit">
    <h3 class="font-semibold mb-3">Log New Period</h3>
    <form method="post" action="<?= e(url_for('/periods/add.php')) ?>" class="space-y-3 text-sm">
      <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
      <label class="block">Start date<input type="date" name="start_date" required class="mt-1 w-full border rounded-xl p-2 bg-transparent"></label>
      <label class="block">End date<input type="date" name="end_date" required class="mt-1 w-full border rounded-xl p-2 bg-transparent"></label>
      <textarea name="notes" placeholder="Symptoms, mood, context..." class="w-full border rounded-xl p-2 bg-transparent"></textarea>
      <div class="grid grid-cols-2 gap-2">
        <label><input type="checkbox" name="cramps" value="1"> Cramps</label><label><input type="checkbox" name="headache" value="1"> Headache</label>
        <label><input type="checkbox" name="mood_swings" value="1"> Mood swings</label><label><input type="checkbox" name="acne" value="1"> Acne</label>
        <label><input type="checkbox" name="fatigue" value="1"> Fatigue</label>
      </div>
      <button class="w-full p-3 bg-brand-500 text-white rounded-xl hover:bg-brand-600 transition">Save Entry</button>
    </form>
  </aside>
</div>
<script>window.cycleData = <?= json_encode($periods, JSON_HEX_TAG|JSON_HEX_AMP|JSON_HEX_APOS|JSON_HEX_QUOT) ?>;</script>
<?php include __DIR__ . '/../includes/footer.php'; ?>
