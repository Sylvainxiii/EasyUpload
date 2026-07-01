<?php

require_once __DIR__ . '/log.php';

/**
 * Web-cron : supprime les FICHIERS des pièces jointes de plus de 7 jours.
 * La base de données n'est PAS modifiée (lecture seule).
 * Inclus depuis public/index.php (après chargement de dotenv) → silencieux.
 */

$dureeVie = 7 * 24 * 3600;        // 7 jours en secondes
$seuil    = time() - $dureeVie;   // tout ce créé avant ce timestamp est périmé

// --- Connexion BDD (lecture seule) ---
try {
    $dbPath = __DIR__ . '/../' . $_ENV['DB_DATABASE'];
    $pdo = new PDO('sqlite:' . $dbPath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    setLog("Connexion BDD échouée (webcron) : " . $e->getMessage(), 'ERROR');
    return; // inclus depuis index.php : on abandonne proprement
}

// --- Garde-fou : on ne supprimera que dans le dossier uploads/ ---
$uploadsDir = realpath(__DIR__ . '/../uploads');
if ($uploadsDir === false) {
    setLog("Webcron : dossier uploads introuvable, abandon.", 'ERROR');
    return;
}

// --- On scanne toutes les pièces jointes ---
$rows       = $pdo->query('SELECT id, date_creation, chemin FROM piece_jointe')->fetchAll(PDO::FETCH_ASSOC);
$supprimees = 0;
$ignorees   = 0;

foreach ($rows as $row) {
    $ts = toTimestamp($row['date_creation']);

    // Date illisible → on ne supprime pas dans le doute (impact minimal)
    if ($ts === null) {
        $ignorees++;
        continue;
    }

    // Pas encore périmée → on garde
    if ($ts >= $seuil) {
        continue;
    }

    if (supprimerFichiers($row['chemin'], $uploadsDir)) {
        $supprimees++;
    }
}

if ($supprimees > 0 || $ignorees > 0) {
    setLog("Webcron : $supprimees fichier(s) supprimé(s), $ignorees ignoré(s) (date illisible).", 'TRACE');
}

// ---------------------------------------------------------------
// FONCTIONS
// ---------------------------------------------------------------

/**
 * Convertit date_creation en timestamp Unix.
 *   - numérique (déjà un timestamp) → intval
 *   - chaîne (ex. "2026-06-25 12:34:56") → strtotime
 * Renvoie null si la valeur est vide ou illisible.
 */
function toTimestamp($value): ?int
{
    $value = trim((string) $value);
    if ($value === '') {
        return null;
    }
    if (ctype_digit($value)) {
        return (int) $value;
    }
    $ts = strtotime($value);
    return $ts === false ? null : $ts;
}

/**
 * Supprime le fichier ou le dossier pointé par $chemin,
 * uniquement s'il se trouve dans le dossier des uploads.
 * Renvoie true si quelque chose a été supprimé.
 */
function supprimerFichiers(string $chemin, string $uploadsDir): bool
{
    // chemin est stocké relativement à src/ (ex. "../uploads/<md5>") : on ancre sur __DIR__
    $cible = realpath(__DIR__ . DIRECTORY_SEPARATOR . $chemin);

    // Déjà absent → rien à faire
    if ($cible === false) {
        return false;
    }

    // Garde-fou : on ne touche qu'au CONTENU de uploads/ (jamais la racine)
    $dansUploads = str_starts_with($cible, $uploadsDir . DIRECTORY_SEPARATOR);

    if (!$dansUploads) {
        setLog("Webcron : chemin hors uploads ignoré ($cible)", 'ERROR');
        return false;
    }

    $ok = supprimerArbre($cible);
    if ($ok) {
        setLog("Webcron : fichiers supprimés ($cible)", 'TRACE');
    } else {
        setLog("Webcron : échec suppression ($cible)", 'ERROR');
    }
    return $ok;
}

/**
 * Suppression récursive d'un fichier ou dossier (chemin absolu déjà vérifié).
 */
function supprimerArbre(string $cible): bool
{
    // Un lien ne se traverse pas, on le détache directement
    if (is_link($cible)) {
        return unlink($cible);
    }
    if (is_dir($cible)) {
        foreach (scandir($cible) ?: [] as $item) {
            if ($item === '.' || $item === '..') {
                continue;
            }
            supprimerArbre($cible . DIRECTORY_SEPARATOR . $item);
        }
        return rmdir($cible);
    }
    if (is_file($cible)) {
        return unlink($cible);
    }
    return false;
}
