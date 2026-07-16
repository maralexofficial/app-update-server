<?php

declare(strict_types=1);

$data = loadApp($app);

$version = $_GET['version'] ?? $data['version'];

$file = APPS_PATH . '/' . $app . '/apk/' . basename($data['apk']);


if (!file_exists($file)) {

    logRequest(
        $app,
        'download_not_found',
        "APK for version $version not found"
    );

    respond([
        'success' => false,
        'error' => [
            'code' => 'apk_missing',
            'message' => 'APK file not found.'
        ]
    ], 404);
}


logRequest(
    $app,
    'download',
    "Downloading version $version"
);


header('Content-Type: application/vnd.android.package-archive');
header('Content-Disposition: attachment; filename="' . basename($file) . '"');
header('Content-Length: ' . filesize($file));

readfile($file);

exit;