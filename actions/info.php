<?php

declare(strict_types=1);

$data = loadApp($app);

respond([
    'success' => true,
    'data' => $data
]);