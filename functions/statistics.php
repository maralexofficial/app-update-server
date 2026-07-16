<?php

declare(strict_types=1);

function saveStatistic(array $data): void
{
    $collection = mongoCollection();

    if ($collection === null) {
        return;
    }

    try {
        $data['createdAt'] =
            new MongoDB\BSON\UTCDateTime();
        $collection->insertOne($data);
    } catch (Throwable $e) {
        debugLog('MongoDB insert failed', [
            'error' => $e->getMessage()
        ]);
    }
}