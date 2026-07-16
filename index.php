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

    logRequest(
        '',
        'missing_parameter',
        'Missing app parameter'
    );

    respond([
        'success' => false,
        'error' => [
            'code' => 'missing_app',
            'message' => 'Missing parameter: app'
        ]
    ], 400);
}

$app = preg_replace('/[^a-zA-Z0-9_-]/', '', $app);

if (!appExists($app)) {
    logRequest($app, 'not_found', 'App does not exist');
    respond([
        'success' => false,
        'error' => [
            'code' => 'unknown_app',
            'message' => "App '$app' not found."
        ]
    ], 404);
}

logRequest($app, 'success');

$data = loadApp($app);

respond([
    'success' => true,
    'data' => $data
]);