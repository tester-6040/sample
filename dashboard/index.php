<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/security.php';
require_once __DIR__ . '/../includes/cycle.php';
require_auth();

$stmt = db()->prepare('SELECT * FROM periods WHERE user_id=? ORDER BY start_date ASC');
$stmt->execute([current_user_id()]);
$periods = $stmt->fetchAll();
$analysis = analyze_cycles($periods);

$healthInsight = $analysis['irregular'] ? 'Your cycle appears irregular this month. Consider stress management and consulting a doctor if persistent.' : 'Your cycle trend looks stable.';

include __DIR__ . '/../includes/header.php';
?>
<div class="grid md:grid-cols-3 gap-4">
  <div class="bg-white dark:bg-slate-800 p-4 rounded-xl shadow col-span-2">
    <h2 class="font-semibold text-xl">Cycle Dashboard</h2>
    <p>Next expected period: <strong><?= e((string)$analysis['next_period']) ?></strong></p>
    <p>Ovulation prediction: <strong><?= e((string)$analysis['ovulation']) ?></strong></p>
    <p>Fertile window: <strong><?= e((string)$analysis['fertile_start']) ?> - <?= e((string)$analysis['fertile_end']) ?></strong></p>
    <p>AI health insight: <span class="text-pink-600"><?= e($healthInsight) ?></span></p>
    <canvas id="cycleChart" class="mt-4"></canvas>
  </div>
  <div class="bg-white dark:bg-slate-800 p-4 rounded-xl shadow">
    <h3 class="font-semibold mb-2">Add Period</h3>
    <form method="post" action="<?= e(url_for('/periods/add.php')) ?>" class="space-y-2">
      <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
      <input type="date" name="start_date" required class="w-full border rounded p-2">
      <input type="date" name="end_date" required class="w-full border rounded p-2">
      <textarea name="notes" placeholder="Notes" class="w-full border rounded p-2"></textarea>
      <label><input type="checkbox" name="cramps" value="1"> Cramps</label>
      <label><input type="checkbox" name="headache" value="1"> Headache</label>
      <label><input type="checkbox" name="mood_swings" value="1"> Mood swings</label>
      <label><input type="checkbox" name="acne" value="1"> Acne</label>
      <label><input type="checkbox" name="fatigue" value="1"> Fatigue</label>
      <button class="w-full p-2 bg-pink-500 text-white rounded">Save</button>
    </form>
  </div>
</div>
<script>
window.cycleData = <?= json_encode($periods, JSON_HEX_TAG|JSON_HEX_AMP|JSON_HEX_APOS|JSON_HEX_QUOT) ?>;
</script>
<?php include __DIR__ . '/../includes/footer.php'; ?>
