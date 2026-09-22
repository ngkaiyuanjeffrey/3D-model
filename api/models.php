<?php
declare(strict_types=1);
require_once __DIR__ . '/models_lib.php';
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');
echo json_encode(model_payload(), JSON_UNESCAPED_SLASHES);
