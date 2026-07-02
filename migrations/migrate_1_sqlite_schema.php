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

function tableExists(PDO $pdo, string $table): bool
{
    $stmt = $pdo->prepare("SELECT name FROM sqlite_master WHERE type = 'table' AND name = :table");
    $stmt->execute(['table' => $table]);
    return (bool) $stmt->fetchColumn();
}

function columnExists(PDO $pdo, string $table, string $column): bool
{
    $stmt = $pdo->query("PRAGMA table_info({$table})");
    foreach ($stmt->fetchAll() as $row) {
        if (($row['name'] ?? null) === $column) {
            return true;
        }
    }
    return false;
}

if (!tableExists($pdo, 'piece_jointe')) {
    fwrite(STDERR, "Table 'piece_jointe' absente, migration annulée." . PHP_EOL);
    exit(1);
}

$hasLegalInfo = tableExists($pdo, 'legal_info');
$hasNewColumn = columnExists($pdo, 'piece_jointe', 'email_emetteur');
$hasOldColumn = columnExists($pdo, 'piece_jointe', 'email_emmeteur');

if ($hasLegalInfo && $hasNewColumn && !$hasOldColumn) {
    fwrite(STDOUT, 'Migration déjà appliquée, aucune action.' . PHP_EOL);
    exit(0);
}

$backupPath = $dbPath . '.backup-' . date('Ymd-His');
if (!copy($dbPath, $backupPath)) {
    fwrite(STDERR, "Impossible de créer la sauvegarde: {$backupPath}" . PHP_EOL);
    exit(1);
}

try {
    $pdo->beginTransaction();

    if ($hasOldColumn) {
        $pdo->exec(
            'CREATE TABLE piece_jointe_new (
                id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
                email_emetteur TEXT NOT NULL,
                email_destinataire TEXT NOT NULL,
                date_creation INTEGER NOT NULL,
                chemin TEXT NOT NULL
            )'
        );

        $pdo->exec(
            'INSERT INTO piece_jointe_new (id, email_emetteur, email_destinataire, date_creation, chemin)
             SELECT id, email_emmeteur, email_destinataire, date_creation, chemin
             FROM piece_jointe'
        );

        $pdo->exec('DROP TABLE piece_jointe');
        $pdo->exec('ALTER TABLE piece_jointe_new RENAME TO piece_jointe');
    }

    $pdo->exec(
        "CREATE TABLE IF NOT EXISTS legal_info (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            section TEXT NOT NULL,
            key TEXT NOT NULL,
            value TEXT NOT NULL,
            created_at INTEGER DEFAULT (strftime('%s', 'now')),
            updated_at INTEGER DEFAULT (strftime('%s', 'now')),
            UNIQUE(section, key)
        )"
    );

    $seedRows = [
        ['editeur', 'firstName', 'John'],
        ['editeur', 'lastName', 'Doe'],
        ['editeur', 'voi', '1'],
        ['editeur', 'rue', "Rue de l'Exemple"],
        ['editeur', 'codepostal', '75000'],
        ['editeur', 'ville', 'Paris'],
        ['editeur', 'departement', 'Paris'],
        ['editeur', 'pays', 'France'],
        ['editeur', 'tel', '0123456789'],
        ['editeur', 'email', 'contact@example.com'],
        ['hebergeur', 'name', 'o2switch'],
        ['hebergeur', 'legal_form', 'SAS'],
        ['hebergeur', 'registration', 'RCS Clermont-Ferrand'],
        ['hebergeur', 'tel', '0444446040'],
        ['hebergeur', 'url', 'https://www.o2switch.fr/'],
        ['rgpd', 'data_retention', '7 jours'],
        ['rgpd', 'log_retention', '12 mois'],
        ['cgu', 'last_update', '2024-01-01'],
        ['privacy', 'last_update', '2024-01-01'],
        ['legal', 'last_update', '2024-01-01'],
    ];

    $insertSeed = $pdo->prepare(
        'INSERT OR IGNORE INTO legal_info (section, key, value) VALUES (:section, :key_name, :value)'
    );

    foreach ($seedRows as [$section, $key, $value]) {
        $insertSeed->execute([
            'section' => $section,
            'key_name' => $key,
            'value' => $value,
        ]);
    }

    $pdo->commit();
} catch (Throwable $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    fwrite(STDERR, 'Migration échouée: ' . $e->getMessage() . PHP_EOL);
    fwrite(STDERR, "Sauvegarde disponible: {$backupPath}" . PHP_EOL);
    exit(1);
}

fwrite(STDOUT, 'Migration terminée.' . PHP_EOL);
fwrite(STDOUT, "Sauvegarde créée: {$backupPath}" . PHP_EOL);
