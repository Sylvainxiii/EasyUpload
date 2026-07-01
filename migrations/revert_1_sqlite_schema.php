<?php

declare(strict_types=1);

use Dotenv\Dotenv;

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$dbFile = $_ENV['DB_DATABASE'] ?? 'bdd.db';
$dbPath = __DIR__ . DIRECTORY_SEPARATOR . ltrim($dbFile, DIRECTORY_SEPARATOR);

if (!is_file($dbPath)) {
    fwrite(STDERR, "Base introuvable: {$dbPath}" . PHP_EOL);
    exit(1);
}

try {
    $pdo = new PDO('sqlite:' . $dbPath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    fwrite(STDERR, 'Connexion SQLite impossible: ' . $e->getMessage() . PHP_EOL);
    exit(1);
}

$tablesToDrop = [
    'legal_info',
];

$backupPath = $dbPath . '.backup-revert-' . date('Ymd-His');
if (!copy($dbPath, $backupPath)) {
    fwrite(STDERR, "Impossible de creer la sauvegarde: {$backupPath}" . PHP_EOL);
    exit(1);
}

try {
    $pdo->beginTransaction();

    foreach ($tablesToDrop as $table) {
        $pdo->exec(sprintf('DROP TABLE IF EXISTS "%s"', $table));
    }

    $pdo->commit();
} catch (Throwable $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    fwrite(STDERR, 'Rollback echoue: ' . $e->getMessage() . PHP_EOL);
    fwrite(STDERR, "Sauvegarde disponible: {$backupPath}" . PHP_EOL);
    exit(1);
}

fwrite(STDOUT, 'Rollback termine.' . PHP_EOL);
fwrite(STDOUT, "Sauvegarde creee: {$backupPath}" . PHP_EOL);
