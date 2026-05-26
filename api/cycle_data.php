<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/security.php';
header('Content-Type: application/json');
require_auth();
$stmt=db()->prepare('SELECT start_date,end_date FROM periods WHERE user_id=? ORDER BY start_date');
$stmt->execute([current_user_id()]);
echo json_encode($stmt->fetchAll());
