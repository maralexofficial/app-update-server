<?php

declare(strict_types=1);

function logRequest(
    string $app,
    string $status = 'success',
    ?string $message = null
): void
{
    $log = [
        'time'    => date('c'),
        'app'     => $app,
        'status'  => $status,
        'ip'      => $_SERVER['REMOTE_ADDR'] ?? '',
        'agent'   => $_SERVER['HTTP_USER_AGENT'] ?? '',
        'current' => $_GET['current'] ?? '',
    ];

    if ($message !== null) {
        $log['message'] = $message;
    }

    file_put_contents(
        LOGS_PATH . '/requests.log',
        json_encode($log, JSON_UNESCAPED_SLASHES) . PHP_EOL,
        FILE_APPEND | LOCK_EX
    );
}