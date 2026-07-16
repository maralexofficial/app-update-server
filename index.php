<?php

$app = $_GET['app'] ?? '';

if (!$app) {
    http_response_code(400);
    exit('Missing app parameter');
}

$app = preg_replace('/[^a-zA-Z0-9_-]/', '', $app);

$file = __DIR__ . "/apps/$app/latest.json";

if (!file_exists($file)) {
    http_response_code(404);
    exit('Unknown app');
}

header('Content-Type: application/json');

$log = [
    'time' => date('c'),
    'app' => $app,
    'ip' => $_SERVER['REMOTE_ADDR'] ?? '',
    'agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
    'current' => $_GET['current'] ?? '',
];

file_put_contents(
    __DIR__ . '/logs/requests.log',
    json_encode($log) . PHP_EOL,
    FILE_APPEND | LOCK_EX
);

readfile($file);