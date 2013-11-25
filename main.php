<?php
require_once __DIR__ . '/vendor/autoload.php';

set_time_limit (0);

$service = new i3or1s\Service();
$service->run();