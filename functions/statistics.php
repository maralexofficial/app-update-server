<?php

declare(strict_types=1);

function saveStatistic(array $data): void
{
    if (!MONGO_ENABLED) {
        return;
    }
    
    try {
        $data['createdAt'] =
            new MongoDB\BSON\UTCDateTime();
        mongoCollection()
            ->insertOne($data);
    } catch (Throwable $e) {
        debugLog(
            'MongoDB error',
            [
                'error' => $e->getMessage()
            ]
        );
    }
}