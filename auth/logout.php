<?php
require_once __DIR__ . '/../includes/security.php';
session_destroy();
redirect_to('/auth/login.php');
