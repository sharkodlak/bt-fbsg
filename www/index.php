<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Bootstrap;

$bootstrap = new Bootstrap();
$configurator = $bootstrap->boot();
$application = $bootstrap->createApplication();

$application->run();
