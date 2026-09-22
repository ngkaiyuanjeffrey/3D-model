<?php
declare(strict_types=1);
require_once __DIR__ . '/site_lib.php';

function model_files(): array
{
    $dir = project_root() . '/assets/models';
    if (!is_dir($dir)) {
        return [];
    }
    $files = glob($dir . '/*.glb') ?: [];
    return array_values(array_filter(array_map('basename', $files), static fn(string $file): bool => preg_match('/^[A-Za-z0-9._-]+\.glb$/i', $file) === 1));
}

function model_payload(): array
{
    $files = model_files();
    $config = read_json_config('models', ['enemy' => 'random', 'weapon' => '']);
    $enemyCandidates = array_values(array_filter($files, static fn(string $file): bool => !preg_match('/(fps|weapon|rifle|akm|pistol|gun)/i', $file)));
    $weaponCandidates = array_values(array_filter($files, static fn(string $file): bool => preg_match('/(fps|weapon|rifle|akm|pistol|gun)/i', $file)));
    $enemy = (string) ($config['enemy'] ?? 'random');
    $weapon = (string) ($config['weapon'] ?? '');
    return [
        'ok' => true,
        'config' => ['enemy' => $enemy, 'weapon' => $weapon],
        'enemyRandom' => $enemy === 'random',
        'weaponRandom' => $weapon === 'random',
        'enemyCandidates' => $enemyCandidates,
        'weaponCandidates' => $weaponCandidates,
        'enemyUrl' => $enemy !== 'random' && in_array($enemy, $enemyCandidates, true) ? 'assets/models/' . rawurlencode($enemy) : '',
        'weaponUrl' => $weapon !== '' && $weapon !== 'random' && in_array($weapon, $weaponCandidates, true) ? 'assets/models/' . rawurlencode($weapon) : ''
    ];
}
