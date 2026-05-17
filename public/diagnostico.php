<?php
// Subir a: /public_html/incluy.admin/public/diagnostico.php
// Acceder en: https://tu-dominio.com/diagnostico.php
// ELIMINAR este archivo una vez resuelto el problema

$root = dirname(__DIR__); // carpeta raíz del proyecto Laravel

function check($label, $ok, $detail = '') {
    $icon = $ok ? '✅' : '❌';
    echo "<tr><td>$icon</td><td><strong>$label</strong></td><td style='color:#555'>$detail</td></tr>";
}

function file_check($path) {
    return file_exists($path) ? '✅ existe' : '❌ NO existe';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Diagnóstico — Incluy Admin</title>
    <style>
        body { font-family: monospace; background: #f0f4f8; padding: 30px; color: #1e2749; }
        h1 { color: #004494; }
        table { border-collapse: collapse; width: 100%; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 4px rgba(0,0,0,.1); }
        th { background: #004494; color: white; text-align: left; padding: 10px 14px; }
        td { padding: 9px 14px; border-bottom: 1px solid #eee; vertical-align: top; }
        tr:last-child td { border-bottom: none; }
        h2 { color: #3c2d6d; margin-top: 30px; }
        pre { background: #1e2749; color: #a8e6cf; padding: 16px; border-radius: 6px; overflow-x: auto; font-size: 13px; }
    </style>
</head>
<body>

<h1>Diagnóstico Incluy Admin</h1>
<p style="color:#6b7c93">Ruta detectada del proyecto: <code><?= $root ?></code></p>

<h2>PHP y Servidor</h2>
<table>
    <tr><th></th><th>Verificación</th><th>Detalle</th></tr>
    <?php
    check('Versión PHP', version_compare(PHP_VERSION, '8.1', '>='), 'PHP ' . PHP_VERSION . ' (mínimo 8.1)');
    check('Extensión pdo_pgsql', extension_loaded('pdo_pgsql'), extension_loaded('pdo_pgsql') ? 'Cargada' : 'FALTA — necesaria para PostgreSQL');
    check('Extensión pdo', extension_loaded('pdo'), extension_loaded('pdo') ? 'Cargada' : 'FALTA');
    check('Extensión openssl', extension_loaded('openssl'), extension_loaded('openssl') ? 'Cargada' : 'FALTA');
    check('Extensión mbstring', extension_loaded('mbstring'), extension_loaded('mbstring') ? 'Cargada' : 'FALTA');
    check('Extensión tokenizer', extension_loaded('tokenizer'), extension_loaded('tokenizer') ? 'Cargada' : 'FALTA');
    check('Extensión fileinfo', extension_loaded('fileinfo'), extension_loaded('fileinfo') ? 'Cargada' : 'FALTA');
    ?>
</table>

<h2>Archivos del proyecto</h2>
<table>
    <tr><th></th><th>Archivo / Carpeta</th><th>Estado</th></tr>
    <?php
    $vendorOk   = is_dir($root . '/vendor');
    $envOk      = file_exists($root . '/.env');
    $storageOk  = is_writable($root . '/storage/logs');
    $bootstrapOk = is_writable($root . '/bootstrap/cache');

    check('vendor/', $vendorOk, $vendorOk ? 'Existe' : 'FALTA — subir vendor/ o correr composer install');
    check('.env', $envOk, $envOk ? 'Existe' : 'FALTA — crear desde .env.example y completar con credenciales');
    check('storage/logs/ escribible', $storageOk, $storageOk ? 'Escribible' : 'Sin permisos de escritura (chmod 775)');
    check('bootstrap/cache/ escribible', $bootstrapOk, $bootstrapOk ? 'Escribible' : 'Sin permisos de escritura (chmod 775)');
    ?>
</table>

<?php if ($envOk): ?>
<h2>Variables .env</h2>
<table>
    <tr><th></th><th>Variable</th><th>Valor</th></tr>
    <?php
    $env = [];
    foreach (file($root . '/.env') as $line) {
        $line = trim($line);
        if ($line && !str_starts_with($line, '#') && str_contains($line, '=')) {
            [$k, $v] = explode('=', $line, 2);
            $env[trim($k)] = trim($v, '"\'');
        }
    }

    $appKey = $env['APP_KEY'] ?? '';
    check('APP_KEY', !empty($appKey), empty($appKey) ? 'VACÍA — correr php artisan key:generate' : substr($appKey, 0, 20) . '...');
    check('DB_CONNECTION', ($env['DB_CONNECTION'] ?? '') === 'pgsql', $env['DB_CONNECTION'] ?? 'no definido');
    check('DB_HOST', !empty($env['DB_HOST'] ?? ''), $env['DB_HOST'] ?? 'no definido');
    check('DB_PORT', !empty($env['DB_PORT'] ?? ''), $env['DB_PORT'] ?? 'no definido');
    check('DB_DATABASE', !empty($env['DB_DATABASE'] ?? ''), $env['DB_DATABASE'] ?? 'no definido');
    check('DB_USERNAME', !empty($env['DB_USERNAME'] ?? ''), $env['DB_USERNAME'] ?? 'no definido');
    $passOk = !empty($env['DB_PASSWORD'] ?? '');
    check('DB_PASSWORD', $passOk, $passOk ? '(definido)' : 'VACÍA');
    check('PGSSLMODE', !empty($env['PGSSLMODE'] ?? ''), $env['PGSSLMODE'] ?? 'no definido');
    check('SESSION_DRIVER', !empty($env['SESSION_DRIVER'] ?? ''), $env['SESSION_DRIVER'] ?? 'no definido');
    ?>
</table>
<?php endif; ?>

<?php if ($envOk && !empty($appKey) && $vendorOk): ?>
<h2>Prueba de conexión a la base de datos</h2>
<?php
try {
    $host = $env['DB_HOST']     ?? '';
    $port = $env['DB_PORT']     ?? '5432';
    $db   = $env['DB_DATABASE'] ?? 'postgres';
    $user = $env['DB_USERNAME'] ?? '';
    $pass = $env['DB_PASSWORD'] ?? '';
    $ssl  = $env['PGSSLMODE']   ?? 'require';

    $dsn = "pgsql:host=$host;port=$port;dbname=$db;sslmode=$ssl";
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $pdo->query("SELECT 1");
    echo '<table><tr><th></th><th>Conexión PostgreSQL</th><th>Resultado</th></tr>';
    echo '<tr><td>✅</td><td><strong>Conexión exitosa</strong></td><td style="color:#555">Conectado a ' . htmlspecialchars($host) . ':' . $port . '</td></tr>';

    // Verificar tablas clave
    $tablas = ['admin_users', 'entidades', 'profesionales'];
    foreach ($tablas as $tabla) {
        try {
            $count = $pdo->query("SELECT COUNT(*) FROM $tabla")->fetchColumn();
            echo "<tr><td>✅</td><td><strong>Tabla $tabla</strong></td><td style='color:#555'>$count registros</td></tr>";
        } catch (Exception $e) {
            echo "<tr><td>❌</td><td><strong>Tabla $tabla</strong></td><td style='color:red'>" . htmlspecialchars($e->getMessage()) . "</td></tr>";
        }
    }
    echo '</table>';
} catch (Exception $e) {
    echo '<table><tr><th></th><th>Conexión PostgreSQL</th><th>Error</th></tr>';
    echo '<tr><td>❌</td><td><strong>Error de conexión</strong></td><td style="color:red">' . htmlspecialchars($e->getMessage()) . '</td></tr>';
    echo '</table>';
}
?>
<?php endif; ?>

<h2>Próximos pasos</h2>
<pre>
# Si falta APP_KEY en .env:
php artisan key:generate

# Si falta vendor/:
composer install --no-dev --optimize-autoloader

# Si storage/ o bootstrap/cache/ no son escribibles:
chmod -R 775 storage/ bootstrap/cache/
chown -R www-data:www-data storage/ bootstrap/cache/
</pre>

<p style="color:#6b7c93; font-size:12px; margin-top:30px">
    ⚠️ Eliminar este archivo del servidor una vez resuelto el problema.
</p>

</body>
</html>
