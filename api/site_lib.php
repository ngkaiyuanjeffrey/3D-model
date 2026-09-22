<?php
declare(strict_types=1);

function project_root(): string
{
    return dirname(__DIR__);
}

function config_path(string $name): string
{
    return project_root() . '/assets/config/' . $name . '.json';
}

function read_json_config(string $name, array $fallback = []): array
{
    $path = config_path($name);
    if (!is_file($path)) {
        return $fallback;
    }
    $data = json_decode((string) file_get_contents($path), true);
    return is_array($data) ? $data : $fallback;
}

function write_json_config(string $name, array $data): bool
{
    $path = config_path($name);
    return (bool) file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES), LOCK_EX);
}

function asset_version(string $relativePath): string
{
    $path = project_root() . '/' . ltrim($relativePath, '/');
    return is_file($path) ? (string) filemtime($path) : '0';
}

function public_game_url(): string
{
    $site = read_json_config('site', ['publicBaseUrl' => '']);
    $base = trim((string) ($site['publicBaseUrl'] ?? ''));
    if ($base !== '') {
        return rtrim($base, '/') . '/game.php';
    }
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $path = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/')), '/');
    return $scheme . '://' . $host . ($path === '/' ? '' : $path) . '/game.php';
}

function h(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
