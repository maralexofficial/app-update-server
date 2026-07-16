<?php

declare(strict_types=1);

function debugLog(
    string $message,
    array $context = []
): void
{
    if (!DEBUG) {
        return;
    }

    if (!is_dir(LOGS_PATH)) {
        mkdir(LOGS_PATH, 0755, true);
    }

    $log = [
        'time' => date('c'),
        'message' => $message,
    ];

    if (!empty($context)) {
        $log['context'] = $context;
    }

    file_put_contents(
        LOGS_PATH . '/debug.log',
        json_encode(
            $log,
            JSON_UNESCAPED_SLASHES
        ) . PHP_EOL,
        FILE_APPEND | LOCK_EX
    );
}