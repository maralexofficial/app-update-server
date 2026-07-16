<?php

declare(strict_types=1);

require __DIR__ . '/config.php';

if (DEBUG) {
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', '0');
    ini_set('display_startup_errors', '0');
    error_reporting(0);
}


require HTTPDOCS_PATH . '/functions/response.php';
require HTTPDOCS_PATH . '/functions/logger.php';
require HTTPDOCS_PATH . '/functions/debug.php';
require HTTPDOCS_PATH . '/functions/app.php';


debugLog('Request started', [
    'uri'   => $_SERVER['REQUEST_URI'] ?? null,
    'query' => $_GET
]);


$app = $_GET['app'] ?? null;


if ($app === null || $app === '') {

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


// App Name bereinigen
$app = preg_replace('/[^a-zA-Z0-9_-]/', '', $app);


debugLog('App resolved', [
    'app' => $app
]);


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


debugLog('Action selected', [
    'action' => $action
]);


$actions = [
    'info',
    'download',
    'changelog'
];


if (!in_array($action, $actions, true)) {

    logRequest(
        $app,
        'unknown_action',
        "Action '$action' not supported"
    );

    respond([
        'success' => false,
        'error' => [
            'code' => 'unknown_action',
            'message' => "Action '$action' not supported."
        ]
    ], 400);
}


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
}