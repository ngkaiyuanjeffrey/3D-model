<?php
declare(strict_types=1);
require_once __DIR__ . '/api/models_lib.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: models.php'); exit; }
$files = model_files();
$enemy = (string) ($_POST['enemy'] ?? 'random');
$weapon = (string) ($_POST['weapon'] ?? '');
if ($enemy !== 'random' && !in_array($enemy, $files, true)) { $enemy = 'random'; }
if ($weapon !== '' && $weapon !== 'random' && !in_array($weapon, $files, true)) { $weapon = ''; }
write_json_config('models', ['enemy' => $enemy, 'weapon' => $weapon, 'updatedAt' => gmdate('c')]);
header('Location: models.php?saved=1');
