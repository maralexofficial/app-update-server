<?php

declare(strict_types=1);

use MongoDB\Client;

function mongoCollection(string $collection = 'requests'): ?object
{
    static $database = null;

    if (
        !defined('MONGO_ENABLED') ||
        MONGO_ENABLED !== true
    ) {
        return null;
    }

    if (
        !defined('MONGO_URI') ||
        trim((string) MONGO_URI) === ''
    ) {
        debugLog('MongoDB unavailable', [
            'reason' => 'Missing MONGO_URI'
        ]);

        return null;
    }

    if (
        !defined('MONGO_DATABASE') ||
        trim((string) MONGO_DATABASE) === ''
    ) {
        debugLog('MongoDB unavailable', [
            'reason' => 'Missing MONGO_DATABASE'
        ]);

        return null;
    }

    if (!class_exists(Client::class)) {
        debugLog('MongoDB unavailable', [
            'reason' => 'MongoDB Client class missing'
        ]);
        return null;
    }

    if ($database === null) {

        try {
            $client = new Client(
                MONGO_URI,
                [
                    'serverSelectionTimeoutMS' => 2000
                ]
            );

            $client
                ->selectDatabase(MONGO_DATABASE)
                ->command([
                    'ping' => 1
                ]);

            $database = $client->selectDatabase(
                MONGO_DATABASE
            );

        } catch (Throwable $e) {
            debugLog('MongoDB connection failed', [
                'error' => $e->getMessage()
            ]);

            return null;
        }
    }

    return $database->selectCollection(
        $collection
    );
}