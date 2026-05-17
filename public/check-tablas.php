<?php
// Temporal — eliminar después
$root = dirname(__DIR__);
$env = [];
foreach (file($root . '/.env') as $line) {
    $line = trim($line);
    if ($line && !str_starts_with($line, '#') && str_contains($line, '=')) {
        [$k, $v] = explode('=', $line, 2);
        $env[trim($k)] = trim($v, '"\'');
    }
}
try {
    $pdo = new PDO(
        "pgsql:host={$env['DB_HOST']};port={$env['DB_PORT']};dbname={$env['DB_DATABASE']};sslmode={$env['PGSSLMODE']}",
        $env['DB_USERNAME'], $env['DB_PASSWORD'],
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    // Buscar tablas de regiones y comunas
    $tables = $pdo->query("SELECT table_name FROM information_schema.tables WHERE table_schema='public' AND table_name ILIKE '%region%' OR table_name ILIKE '%comuna%' ORDER BY table_name")->fetchAll(PDO::FETCH_COLUMN);
    echo "<h3>Tablas encontradas:</h3><pre>" . implode("\n", $tables) . "</pre>";
    foreach ($tables as $t) {
        $cols = $pdo->query("SELECT column_name, data_type FROM information_schema.columns WHERE table_name='$t' ORDER BY ordinal_position")->fetchAll(PDO::FETCH_ASSOC);
        echo "<h4>$t</h4><pre>";
        foreach ($cols as $c) echo "{$c['column_name']} ({$c['data_type']})\n";
        echo "</pre>";
        $sample = $pdo->query("SELECT * FROM $t LIMIT 3")->fetchAll(PDO::FETCH_ASSOC);
        echo "<pre>" . json_encode($sample, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "</pre>";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
