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
        'app'     => $app !== '' ? $app : null,
        'status'  => $status,
        'ip'      => $_SERVER['REMOTE_ADDR'] ?? null,
        'agent'   => $_SERVER['HTTP_USER_AGENT'] ?? null,
        'current' => $_GET['current'] ?? null,
        'query'   => $_SERVER['QUERY_STRING'] ?? null,
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