<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/config.php';

function get_lang(): string
{
    $lang = $_GET['lang'] ?? $_SESSION['lang'] ?? 'en';
    if (!in_array($lang, SUPPORTED_LANGS, true)) {
        $lang = 'en';
    }
    $_SESSION['lang'] = $lang;
    return $lang;
}

function t(string $key): string
{
    $lang = get_lang();
    static $translations = [];
    if (!isset($translations[$lang])) {
        $translations[$lang] = require __DIR__ . '/../lang/' . $lang . '.php';
    }

    return $translations[$lang][$key] ?? $key;
}
