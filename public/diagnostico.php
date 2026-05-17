<?php
// Diagnóstico v2 — eliminar después de resolver
$root = dirname(__DIR__);

// Leer .env
$env = [];
if (file_exists($root . '/.env')) {
    foreach (file($root . '/.env') as $line) {
        $line = trim($line);
        if ($line && !str_starts_with($line, '#') && str_contains($line, '=')) {
            [$k, $v] = explode('=', $line, 2);
            $env[trim($k)] = trim($v, '"\'');
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Diagnóstico v2</title>
    <style>
        body { font-family: monospace; background: #f0f4f8; padding: 30px; color: #1e2749; }
        h2 { color: #004494; }
        table { border-collapse: collapse; width: 100%; background: white; border-radius: 8px; margin-bottom: 20px; }
        th { background: #004494; color: white; text-align: left; padding: 8px 12px; }
        td { padding: 8px 12px; border-bottom: 1px solid #eee; }
        pre { background: #1e2749; color: #a8e6cf; padding: 12px; border-radius: 6px; font-size: 12px; overflow-x: auto; }
        .ok  { color: green; }
        .err { color: red; }
    </style>
</head>
<body>

<h2>1. mod_rewrite status</h2>
<table>
<tr><th>Verificación</th><th>Resultado</th></tr>
<tr>
    <td>mod_rewrite cargado</td>
    <td><?= function_exists('apache_get_modules')
        ? (in_array('mod_rewrite', apache_get_modules()) ? '<span class="ok">✅ SÍ</span>' : '<span class="err">❌ NO — ese es el problema</span>')
        : '<span style="color:orange">⚠️ No se puede detectar (PHP no corre como módulo Apache)</span>' ?></td>
</tr>
<tr>
    <td>SERVER_SOFTWARE</td>
    <td><?= htmlspecialchars($_SERVER['SERVER_SOFTWARE'] ?? 'no disponible') ?></td>
</tr>
<tr>
    <td>DOCUMENT_ROOT</td>
    <td><?= htmlspecialchars($_SERVER['DOCUMENT_ROOT'] ?? 'no disponible') ?></td>
</tr>
<tr>
    <td>SCRIPT_FILENAME</td>
    <td><?= htmlspecialchars($_SERVER['SCRIPT_FILENAME'] ?? 'no disponible') ?></td>
</tr>
</table>

<h2>2. Archivos de caché en bootstrap/cache/</h2>
<table>
<tr><th>Archivo</th><th>Estado</th></tr>
<?php
$cacheDir = $root . '/bootstrap/cache/';
$files = glob($cacheDir . '*.php');
if (empty($files)) {
    echo '<tr><td colspan="2"><span class="ok">✅ Sin archivos de caché PHP</span></td></tr>';
} else {
    foreach ($files as $f) {
        echo '<tr><td>' . basename($f) . '</td><td><span class="err">❌ Existe — puede estar obsoleto</span></td></tr>';
    }
}
?>
</table>

<h2>3. Eliminar caché ahora</h2>
<?php
$deleted = [];
$files = glob($root . '/bootstrap/cache/*.php');
foreach ($files as $f) {
    if (basename($f) !== '.gitignore' && unlink($f)) {
        $deleted[] = basename($f);
    }
}
if (empty($deleted)) {
    echo '<p class="ok">✅ No había caché o ya estaba limpio</p>';
} else {
    foreach ($deleted as $f) {
        echo '<p class="ok">✅ Eliminado: ' . $f . '</p>';
    }
}
?>

<h2>4. Prueba de rutas con PHP incluido</h2>
<?php
// Intentar cargar Laravel y listar rutas
try {
    require $root . '/vendor/autoload.php';
    $app = require $root . '/bootstrap/app.php';
    $app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();
    $routes = \Illuminate\Support\Facades\Route::getRoutes();
    $routeNames = [];
    foreach ($routes as $route) {
        if ($route->getName()) {
            $routeNames[] = $route->getMethods()[0] . ' /' . $route->uri() . ' → ' . $route->getName();
        }
    }
    echo '<p class="ok">✅ Laravel cargó correctamente. Rutas nombradas registradas:</p>';
    echo '<pre>' . implode("\n", $routeNames) . '</pre>';
} catch (\Throwable $e) {
    echo '<p class="err">❌ Error al cargar Laravel: ' . htmlspecialchars($e->getMessage()) . '</p>';
    echo '<pre>' . htmlspecialchars($e->getTraceAsString()) . '</pre>';
}
?>

<p style="margin-top:30px;color:#999;font-size:11px">⚠️ Eliminar este archivo del servidor.</p>
</body>
</html>
