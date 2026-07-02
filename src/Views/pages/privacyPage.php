<?php
/**
 * @var string $title
 * @var string $appName
 * @var string $contactEmail
 * @var string $dataRetention
 * @var string $logRetention
 * @var object $editeur
 */
?>

<div class="container py-5">
    <h1 class="mb-4"><?= htmlspecialchars($title) ?></h1>

    <section class="mb-5">
        <h2>1. Collecte des données</h2>
        <p>Les informations recueillies sur ce site sont enregistrées dans un fichier informatisé par <strong><?= htmlspecialchars("$editeur->firstName $editeur->lastName") ?></strong> (<?= htmlspecialchars($contactEmail) ?>) pour <strong>assurer le service d'upload et de partage de fichiers</strong>.</p>
        <p>La base légale du traitement est le consentement de l'utilisateur et l'exécution des mesures précontractuelles.</p>
    </section>

    <section class="mb-5">
        <h2>2. Destinataires des données</h2>
        <p>Les données collectées seront communiquées aux seuls destinataires suivants : <strong>l'équipe d'administration du site et l'hébergeur</strong> dans le cadre de la maintenance et de la sécurisation du service.</p>
    </section>

    <section class="mb-5">
        <h2>3. Durée de conservation</h2>
        <p>Les données sont conservées pendant :</p>
        <ul>
            <li><strong>Fichiers uploadés :</strong> <?= htmlspecialchars($dataRetention) ?></li>
            <li><strong>Logs de connexion :</strong> <?= htmlspecialchars($logRetention) ?></li>
        </ul>
    </section>

    <section class="mb-5">
        <h2>4. Vos droits (RGPD)</h2>
        <p>En fonction de la base légale du traitement, vous pouvez retirer votre consentement au traitement de vos données à tout moment. Vous disposez des droits suivants :</p>
        <ul>
            <li>Droit d'accès à vos données</li>
            <li>Droit de rectification</li>
            <li>Droit à l'effacement (droit à l'oubli)</li>
            <li>Droit d'opposition</li>
            <li>Droit à la portabilité (obtenir une copie de vos données dans un format structuré)</li>
        </ul>
        <p>Pour toute demande relative à vos droits, merci de nous contacter à l'adresse : <a href="mailto:<?= htmlspecialchars($contactEmail) ?>"><?= htmlspecialchars($contactEmail) ?></a>.</p>
        <p>Vous avez également le droit de déposer une réclamation auprès de la <a href="https://www.cnil.fr" target="_blank" rel="noopener noreferrer">CNIL</a> si vous estimez que vos droits n'ont pas été respectés.</p>
    </section>

    <section class="mb-5">
        <h2>5. Cookies</h2>
        <p>Le site n'utilise pas de cookies de traçage. Seuls les cookies techniques nécessaires au bon fonctionnement du service peuvent être utilisés (session, préférences).</p>
    </section>

    <section class="mb-5">
        <h2>6. Services tiers - Cloudflare Turnstile</h2>
        <p>Ce site utilise <strong>Cloudflare Turnstile</strong> pour la protection anti-bot. Ce service peut collecter et traiter les données suivantes :</p>
        <ul>
            <li>Adresse IP</li>
            <li>Informations sur le navigateur et le système d'exploitation</li>
            <li>Date et heure de la requête</li>
            <li>Comportement de navigation (mouvements de souris, temps de réponse)</li>
        </ul>
        <p>Ces données sont utilisées uniquement pour déterminer si le visiteur est un humain ou un robot. Elles ne sont pas utilisées à d'autres fins.</p>
        <p>Pour plus d'informations, consultez : </p>
        <p><a href="https://www.cloudflare.com/turnstile-privacy-policy/" target="_blank" rel="noopener noreferrer">politique de confidentialité de Cloudflare</a>.</p>
        <p><a href="https://www.cloudflare.com/trust-hub/gdpr/" target="_blank" rel="noopener noreferrer">RGPD Cloudflare Turnstile</a></p>
    </section>

    <p class="text-muted mt-4">Dernière mise à jour : <?= date('d/m/Y') ?></p>
</div>
