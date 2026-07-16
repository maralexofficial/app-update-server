<?php

declare(strict_types=1);

function logRequest(
    string $app,
    string $status = 'success',
    ?string $message = null
): void
{
    if (!is_dir(LOGS_PATH)) {
        if (!mkdir(LOGS_PATH, 0755, true) && !is_dir(LOGS_PATH)) {
            error_log('Unable to create log directory: ' . LOGS_PATH);
            return;
        }
    }

    if (!is_writable(LOGS_PATH)) {
        error_log('Log directory is not writable: ' . LOGS_PATH);
        return;
    }

    $log = [
        'time'    => date('c'),

        'method'  => $_SERVER['REQUEST_METHOD'] ?? null,
        'uri'     => $_SERVER['REQUEST_URI'] ?? null,
        'query'   => !empty($_SERVER['QUERY_STRING'])
            ? $_SERVER['QUERY_STRING']
            : null,

        'app'     => $app !== '' ? $app : null,
        'status'  => $status,

        'ip'      => $_SERVER['REMOTE_ADDR'] ?? null,
        'agent'   => $_SERVER['HTTP_USER_AGENT'] ?? null,

        'current' => $_GET['current'] ?? null,
    ];

    if ($message !== null) {
        $log['message'] = $message;
    }

    file_put_contents(
        LOGS_PATH . '/requests.log',
        json_encode(
            $log,
            JSON_UNESCAPED_SLASHES
        ) . PHP_EOL,
        FILE_APPEND | LOCK_EX
    );
}