<?php

declare(strict_types=1);

$file = APPS_PATH . '/' . $app . '/CHANGELOG.md';

if (!file_exists($file)) {

    logRequest(
        $app,
        'changelog_not_found',
        'Changelog does not exist'
    );

    respond([
        'success' => false,
        'error' => [
            'code' => 'missing_changelog',
            'message' => 'Changelog not found.'
        ]
    ], 404);
}


header('Content-Type: text/markdown; charset=utf-8');

echo file_get_contents($file);

exit;