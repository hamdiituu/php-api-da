<?php

$host = 'localhost';
$port = '8080';
$rootDir = __DIR__;

echo "Starting server at http://{$host}:{$port}\n";
exec("php -S {$host}:{$port} -t {$rootDir} &");