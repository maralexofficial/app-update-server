<?php

declare(strict_types=1);

use MongoDB\Client;

function mongoCollection(string $collection = 'requests')
{
    static $db = null;

    if ($db === null) {

        $client = new Client(MONGO_URI);
        $db = $client->selectDatabase(
            MONGO_DATABASE
        );
    }

    return $db->selectCollection($collection);
}