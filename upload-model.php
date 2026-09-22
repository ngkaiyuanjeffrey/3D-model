<?php
declare(strict_types=1);
require_once __DIR__ . '/api/site_lib.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_FILES['model'])) { header('Location: models.php?error=No+model+received'); exit; }
$file = $_FILES['model'];
$original = (string) ($file['name'] ?? '');
if ($file['error'] !== UPLOAD_ERR_OK || $file['size'] > 40 * 1024 * 1024 || !preg_match('/\.glb$/i', $original)) { header('Location: models.php?error=Upload+a+GLB+file+under+40MB'); exit; }
$handle = fopen($file['tmp_name'], 'rb');
$magic = $handle ? fread($handle, 4) : false;
if ($handle) { fclose($handle); }
if ($magic !== 'glTF') { header('Location: models.php?error=The+file+is+not+a+valid+GLB'); exit; }
$name = preg_replace('/[^A-Za-z0-9._-]/', '-', basename($original)) ?: 'model.glb';
$dir = project_root() . '/assets/models';
if (!is_dir($dir)) { mkdir($dir, 0755, true); }
$destination = $dir . '/' . $name;
if (is_file($destination)) { $destination = $dir . '/' . pathinfo($name, PATHINFO_FILENAME) . '-' . bin2hex(random_bytes(3)) . '.glb'; }
move_uploaded_file($file['tmp_name'], $destination);
header('Location: models.php?saved=1');
