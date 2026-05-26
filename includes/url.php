<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/config.php';

function base_path(): string
{
    $path = (string)(parse_url(BASE_URL, PHP_URL_PATH) ?? '');
    $path = rtrim($path, '/');
    return $path === '' ? '' : $path;
}

function url_for(string $path = ''): string
{
    $path = '/' . ltrim($path, '/');
    return base_path() . $path;
}

function redirect_to(string $path): void
{
    header('Location: ' . url_for($path));
    exit;
}
