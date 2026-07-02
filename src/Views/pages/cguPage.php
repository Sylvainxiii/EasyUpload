<?php
/**
 * @var string $title
 * @var string $appName
 * @var string $contactEmail
 * @var string $dataRetention
 * @var string $logRetention
 */
?>

<div class="container py-5">
    <h1 class="mb-4"><?= htmlspecialchars($title) ?></h1>

    <section class="mb-5">
        <h2>1. Acceptation des conditions</h2>
        <p>L'utilisation du site <?= htmlspecialchars($appName) ?> implique l'acceptation pleine et entière des présentes CGU.</p>
    </section>

    <section class="mb-5">
        <h2>2. Service proposé</h2>
        <p>Le site permet l'upload et le partage de fichiers. Les fichiers sont automatiquement supprimés après <?= htmlspecialchars($dataRetention) ?>.</p>
    </section>

    <section class="mb-5">
        <h2>3. Contenu interdit</h2>
        <p>Il est interdit d'uploader des fichiers :</p>
        <ul>
            <li>Contenant des virus ou logiciels malveillants</li>
            <li>Portant atteinte aux droits d'auteur</li>
            <li>À caractère illégal, diffamatoire ou pornographique</li>
        </ul>
    </section>

    <section class="mb-5">
        <h2>4. Responsabilité</h2>
        <p>L'utilisateur est seul responsable des fichiers qu'il upload et partage. L'éditeur ne peut être tenu responsable d'une utilisation abusive.</p>
    </section>

    <section class="mb-5">
        <h2>5. Données personnelles</h2>
        <p>Conformément au RGPD, les logs sont conservés <?= htmlspecialchars($logRetention) ?>. Pour toute demande, contactez <a href="mailto:<?= htmlspecialchars($contactEmail) ?>"><?= htmlspecialchars($contactEmail) ?></a>.</p>
    </section>

    <section class="mb-5">
        <h2>6. Modification des CGU</h2>
        <p>L'éditeur se réserve le droit de modifier les présentes CGU à tout moment.</p>
    </section>

    <section class="mb-5">
        <h2>7. Droit applicable</h2>
        <p>Les présentes CGU sont régies par le droit français.</p>
    </section>
</div>
