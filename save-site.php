<?php
declare(strict_types=1);
require_once __DIR__ . '/api/site_lib.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: index.php'); exit; }
$base = trim((string) ($_POST['publicBaseUrl'] ?? ''));
if ($base !== '' && filter_var($base, FILTER_VALIDATE_URL) === false) { header('Location: index.php?error=' . rawurlencode('Enter a valid public URL.')); exit; }
write_json_config('site', ['publicBaseUrl' => rtrim($base, '/')]);
header('Location: index.php?saved=1');
