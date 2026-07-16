<?php

declare(strict_types=1);

define('HTTPDOCS_PATH', __DIR__);
define('ROOT_PATH', dirname(HTTPDOCS_PATH));

define('APPS_PATH', HTTPDOCS_PATH . '/apps');
define('FUNCTIONS_PATH', HTTPDOCS_PATH . '/functions');
define('ACTIONS_PATH', HTTPDOCS_PATH . '/actions');

define('LOGS_PATH', ROOT_PATH . '/logs');

define('DEBUG', true);