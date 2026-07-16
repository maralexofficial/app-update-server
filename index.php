<?php

declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require __DIR__ . '/config.php';

require BASE_PATH . '/functions/response.php';
require BASE_PATH . '/functions/logger.php';
require BASE_PATH . '/functions/app.php';

$app = $_GET['app'] ?? '';

if ($app === '') {
    respond([
        'success' => false,
        'error' => [
            'code' => 'missing_app',
            'message' => 'Missing parameter: app'
        ]
    ], 400);
}

logRequest($app);

$data = loadApp($app);

respond([
    'success' => true,
    'data' => $data
]);