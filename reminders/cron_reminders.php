<?php
require_once __DIR__ . '/../config/database.php';
$stmt = db()->query("SELECT r.*,u.email FROM reminders r JOIN users u ON u.id=r.user_id WHERE r.enabled=1 AND r.remind_at <= NOW()");
foreach ($stmt->fetchAll() as $row) {
  // send email/sms/whatsapp integrations can be wired here.
}
