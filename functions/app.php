<?php

declare(strict_types=1);

function loadApp(string $app): array
{
    $app = preg_replace('/[^a-zA-Z0-9_-]/', '', $app);

    $file = APP_PATH . '/' . $app . '/latest.json';

    if (!file_exists($file)) {
        respond([
            'success' => false,
            'error' => [
                'code' => 'unknown_app',
                'message' => "App '$app' not found."
            ]
        ], 404);
    }

    $content = file_get_contents($file);

    if ($content === false) {
        respond([
            'success' => false,
            'error' => [
                'code' => 'read_error',
                'message' => 'Unable to read app configuration.'
            ]
        ], 500);
    }

    $data = json_decode($content, true);

    if (!is_array($data)) {
        respond([
            'success' => false,
            'error' => [
                'code' => 'invalid_json',
                'message' => 'Invalid app configuration.'
            ]
        ], 500);
    }

    return $data;
}