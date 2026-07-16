<?php

declare(strict_types=1);

define('HTTPDOCS_PATH', __DIR__);
define('ROOT_PATH', dirname(HTTPDOCS_PATH));

define('APPS_PATH', HTTPDOCS_PATH . '/apps');
define('FUNCTIONS_PATH', HTTPDOCS_PATH . '/functions');
define('ACTIONS_PATH', HTTPDOCS_PATH . '/actions');

define('LOGS_PATH', ROOT_PATH . '/logs');

require ROOT_PATH . '/vendor/autoload.php';

$dotenv = Dotenv::createImmutable(ROOT_PATH);
$dotenv->load();

define(
    'DEBUG',
    filter_var(
        $_ENV['DEBUG'] ?? false,
        FILTER_VALIDATE_BOOLEAN
    )
);

define(
    'MONGO_ENABLED',
    filter_var(
        $_ENV['MONGO_ENABLED'] ?? false,
        FILTER_VALIDATE_BOOLEAN
    )
);

define(
    'MONGO_URI',
    $_ENV['MONGO_URI'] ?? ''
);

define(
    'MONGO_DATABASE',
    $_ENV['MONGO_DATABASE'] ?? 'update_server'
);