<?php

declare(strict_types=1);

function logRequest(string $app): void
{
    $log = [
        'time'    => date('c'),
        'app'     => $app,
        'ip'      => $_SERVER['REMOTE_ADDR'] ?? '',
        'agent'   => $_SERVER['HTTP_USER_AGENT'] ?? '',
        'current' => $_GET['current'] ?? '',
    ];

    file_put_contents(
        LOG_PATH . '/requests.log',
        json_encode($log, JSON_UNESCAPED_SLASHES) . PHP_EOL,
        FILE_APPEND | LOCK_EX
    );
}