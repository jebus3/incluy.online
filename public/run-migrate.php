<?php
// Temporal — eliminar después de correr
define('LARAVEL_START', microtime(true));
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$status = $kernel->call('migrate', ['--force' => true]);
echo "<pre>Exit status: $status\n";
echo $kernel->output();
echo "\nListo. Elimina este archivo del servidor.</pre>";
