<?php
/**
 * @var string $title
 * @var object $editeur
 * @var object $hebergeur
 */
?>

<div class="container py-5">
    <h1 class="mb-4"><?= htmlspecialchars($title) ?></h1>

    <!-- Éditeur -->
    <section class="mb-5">
        <h2>Éditeur du site</h2>
        <p><strong>Nom :</strong> <?= htmlspecialchars($editeur->firstName) ?></p>
        <p><strong>Prénom :</strong> <?= htmlspecialchars($editeur->lastName) ?></p>
        <p><strong>Adresse :</strong> <?= htmlspecialchars("$editeur->voi $editeur->rue, $editeur->codepostal $editeur->ville, $editeur->departement, $editeur->pays") ?></p>
        <p><strong>Téléphone :</strong> <a href="tel:<?= htmlspecialchars($editeur->tel) ?>"><?= htmlspecialchars($editeur->tel) ?></a></p>
        <p><strong>Email :</strong> <a href="mailto:<?= htmlspecialchars($editeur->email) ?>"><?= htmlspecialchars($editeur->email) ?></a></p>
        <p><strong>Directeur de la publication :</strong> <?= htmlspecialchars("$editeur->firstName $editeur->lastName") ?></p>
    </section>

    <!-- Hébergement -->
    <section class="mb-5">
        <h2>Hébergement du site</h2>
        <p>Le site <strong><?= htmlspecialchars($_ENV['APP_URL'] ?? '') ?></strong> est hébergé par <strong><?= htmlspecialchars($hebergeur->name) ?></strong>, société <?= htmlspecialchars($hebergeur->legal_form) ?>.</p>
        <p>Immatriculée au <?= htmlspecialchars($hebergeur->registration) ?>.</p>
        <p>Téléphone : <a href="tel:<?= htmlspecialchars($hebergeur->tel) ?>"><?= htmlspecialchars($hebergeur->tel) ?></a></p>
        <p>Site web : <a href="<?= htmlspecialchars($hebergeur->url) ?>" target="_blank" rel="noopener noreferrer"><?= htmlspecialchars($hebergeur->url) ?></a></p>
    </section>

    <!-- Sécurité - Cloudflare Turnstile -->
    <section class="mb-5">
        <h2>Sécurité et protection anti-bot</h2>
        <p>Ce site utilise <strong>Cloudflare Turnstile</strong> pour protéger le service contre les robots et les abus. Turnstile est une solution de vérification qui ne nécessite pas de captcha interactif, respectant ainsi la vie privée des utilisateurs.</p>
        
        <h3>Politique de confidentialité de Cloudflare</h3>
        <p>Cloudflare Turnstile peut collecter certaines données techniques (adresse IP, navigateur, etc.) pour vérifier qu'un visiteur est bien un humain. Ces données sont traitées conformément à la <a href="https://www.cloudflare.com/turnstile-privacy-policy/" target="_blank" rel="noopener noreferrer">politique de confidentialité de Cloudflare</a>.</p>
        
        <p>Pour plus d'informations : </p>
        <p><a href="https://www.cloudflare.com/products/turnstile/" target="_blank" rel="noopener noreferrer">Site officiel de Cloudflare Turnstile</a></p>
        <p><a href="https://www.cloudflare.com/trust-hub/gdpr/" target="_blank" rel="noopener noreferrer">RGPD Cloudflare Turnstile</a></p>
    </section>

    <!-- Propriété intellectuelle -->
    <section class="mb-5">
        <h2>Propriété intellectuelle</h2>
        <p>Le contenu de ce site web (textes, images, logos, etc.), sauf indication contraire, est la propriété exclusive de <?= htmlspecialchars("$editeur->firstName $editeur->lastName") ?>. Toute reproduction, représentation, modification, publication ou adaptation de tout ou partie des éléments de ce site est interdite, sauf autorisation écrite préalable.</p>

        <h3>Licence MIT</h3>
        <p>Les éléments du code source utilisés dans le cadre de ce site sont mis à disposition sous la licence MIT. Vous êtes autorisé à utiliser, copier, modifier, fusionner, publier, distribuer, sous-licencier et/ou vendre des copies du logiciel, sous réserve que les conditions suivantes soient respectées :</p>
        <ul>
            <li>La mention du copyright et les avis de permission doivent être inclus dans toutes les copies ou parties substantielles du logiciel.</li>
            <li>Le logiciel est fourni "tel quel", sans garantie d'aucune sorte, explicite ou implicite, y compris, mais sans s'y limiter, les garanties de qualité marchande, d'adaptation à un usage particulier et d'absence de contrefaçon.</li>
        </ul>
    </section>

    <!-- Responsabilité -->
    <section class="mb-5">
        <h2>Responsabilité</h2>
        <p>Les informations présentes sur ce site sont fournies à titre informatif. <?= htmlspecialchars("$editeur->firstName $editeur->lastName") ?> ne peut être tenu responsable des erreurs ou omissions, ni des dommages découlant de l'utilisation des informations fournies sur le site.</p>
    </section>
</div>
