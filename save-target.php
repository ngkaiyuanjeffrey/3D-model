<?php
declare(strict_types=1);
require_once __DIR__ . '/api/site_lib.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); exit('Method not allowed'); }
$data = file_get_contents('php://input');
if ($data === false || strlen($data) < 16 || strlen($data) > 20 * 1024 * 1024) { http_response_code(400); exit('Invalid target data'); }
$dir = project_root() . '/assets/targets';
if (!is_dir($dir)) { mkdir($dir, 0755, true); }
if (file_put_contents($dir . '/targets.mind', $data, LOCK_EX) === false) { http_response_code(500); exit('Could not save target'); }
header('Content-Type: application/json');
echo json_encode(['ok' => true]);
