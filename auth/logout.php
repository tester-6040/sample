<?php
require_once __DIR__ . '/../includes/security.php';
session_destroy();
header('Location: /auth/login.php');
