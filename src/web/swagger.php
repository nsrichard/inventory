<?php
require __DIR__ . '/../vendor/autoload.php';

use OpenApi\Generator;

header('Content-Type: application/json');

$openapi = Generator::scan([__DIR__ . '/../src/controllers']); // o app/controllers
echo json_encode($openapi, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
