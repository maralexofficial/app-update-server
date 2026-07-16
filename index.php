<?php

declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require __DIR__ . '/config.php';

require HTTPDOCS_PATH . '/functions/response.php';
require HTTPDOCS_PATH . '/functions/logger.php';
require HTTPDOCS_PATH . '/functions/app.php';


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

    logRequest(
        $app,
        'not_found',
        'App does not exist'
    );

    respond([
        'success' => false,
        'error' => [
            'code' => 'unknown_app',
            'message' => "App '$app' not found."
        ]
    ], 404);
}


$action = $_GET['action'] ?? 'info';


logRequest(
    $app,
    'request',
    "Action: $action"
);


switch ($action) {

    case 'info':
        require ACTIONS_PATH . '/info.php';
        break;


    case 'download':
        require ACTIONS_PATH . '/download.php';
        break;


    case 'changelog':
        require ACTIONS_PATH . '/changelog.php';
        break;


    default:

        respond([
            'success' => false,
            'error' => [
                'code' => 'unknown_action',
                'message' => "Action '$action' not supported."
            ]
        ], 400);
}