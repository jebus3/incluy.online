<?php
// Subir a: /public_html/incluy.admin/public/limpiar-cache.php
// Acceder UNA VEZ y luego eliminar del servidor

$root = dirname(__DIR__);
$deleted = [];
$errors  = [];

$cacheFiles = [
    $root . '/bootstrap/cache/routes-v7.php',
    $root . '/bootstrap/cache/config.php',
    $root . '/bootstrap/cache/packages.php',
    $root . '/bootstrap/cache/services.php',
    $root . '/bootstrap/cache/events.php',
];

foreach ($cacheFiles as $file) {
    if (file_exists($file)) {
        if (unlink($file)) {
            $deleted[] = basename($file);
        } else {
            $errors[] = basename($file) . ' (sin permisos para eliminar)';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Limpiar caché — Incluy Admin</title>
    <style>
        body { font-family: monospace; background: #f0f4f8; padding: 30px; color: #1e2749; }
        .ok  { background: #d1fae5; border: 1px solid #6ee7b7; padding: 12px 16px; border-radius: 8px; margin: 8px 0; }
        .err { background: #fee2e2; border: 1px solid #fca5a5; padding: 12px 16px; border-radius: 8px; margin: 8px 0; }
        .info{ background: #dbeafe; border: 1px solid #93c5fd; padding: 12px 16px; border-radius: 8px; margin: 8px 0; }
    </style>
</head>
<body>
    <h1 style="color:#004494">Limpieza de caché</h1>

    <?php if (empty($deleted) && empty($errors)): ?>
        <div class="info">ℹ️ No había archivos de caché para eliminar. Ya estaba limpio.</div>
    <?php endif; ?>

    <?php foreach ($deleted as $f): ?>
        <div class="ok">✅ Eliminado: <strong><?= $f ?></strong></div>
    <?php endforeach; ?>

    <?php foreach ($errors as $f): ?>
        <div class="err">❌ Error al eliminar: <strong><?= $f ?></strong></div>
    <?php endforeach; ?>

    <div class="info" style="margin-top:20px">
        ⚠️ <strong>Elimina este archivo del servidor una vez que funcione.</strong><br>
        Luego prueba: <a href="/" style="color:#004494">https://incluy.online/</a>
    </div>
</body>
</html>
