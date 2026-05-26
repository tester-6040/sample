<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/security.php';
require_auth();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && verify_csrf($_POST['csrf'] ?? null)) {
  $stmt = db()->prepare('INSERT INTO periods(user_id,start_date,end_date,notes,created_at) VALUES(?,?,?,?,NOW())');
  $stmt->execute([
    current_user_id(),
    $_POST['start_date'] ?? null,
    $_POST['end_date'] ?? null,
    trim($_POST['notes'] ?? '')
  ]);
  $periodId = (int)db()->lastInsertId();
  $symptoms = ['cramps','headache','mood_swings','acne','fatigue'];
  foreach ($symptoms as $symptom) {
    if (!empty($_POST[$symptom])) {
      $s = db()->prepare('INSERT INTO symptoms (user_id,period_id,symptom,severity,created_at) VALUES(?,?,?,?,NOW())');
      $s->execute([current_user_id(), $periodId, $symptom, (int)($_POST[$symptom.'_severity'] ?? 3)]);
    }
  }
  header('Location: /dashboard/index.php?added=1'); exit;
}
