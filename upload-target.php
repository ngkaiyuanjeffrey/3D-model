<?php
declare(strict_types=1);
require_once __DIR__ . '/api/site_lib.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_FILES['target'])) { header('Location: index.php?error=No+image+received'); exit; }
$file = $_FILES['target'];
if ($file['error'] !== UPLOAD_ERR_OK || $file['size'] > 12 * 1024 * 1024) { header('Location: index.php?error=Upload+failed+or+file+is+over+12MB'); exit; }
$info = @getimagesize($file['tmp_name']);
$allowed = ['image/jpeg' => 'jpg', 'image/png' => 'jpg', 'image/webp' => 'jpg'];
if (!$info || !isset($allowed[$info['mime']])) { header('Location: index.php?error=Use+a+valid+JPG,+PNG,+or+WEBP+image'); exit; }
$targetDir = project_root() . '/assets/targets';
if (!is_dir($targetDir)) { mkdir($targetDir, 0755, true); }
$image = @imagecreatefromstring((string) file_get_contents($file['tmp_name']));
if (!$image || !imagejpeg($image, $targetDir . '/picture.jpg', 90)) { header('Location: index.php?error=The+image+could+not+be+converted'); exit; }
imagedestroy($image);
@unlink($targetDir . '/targets.mind');
header('Location: ' . (!empty($_POST['compile']) ? 'compile-target.php' : 'index.php?saved=1'));
