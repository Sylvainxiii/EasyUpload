<?php

/**
 * @var string $appName
 */

declare(strict_types=1);

namespace App\Views\components;

?>

<footer>
    <div class="text-center mt-4">
        <a href="/mentions-legales">Mentions légales</a> | 
        <a href="/cgu">CGU</a> | 
        <!-- <a href="/cgv">CGV</a> |  -->
        <a href="/confidentialite">Politique de confidentialité</a>
    </div>

    <div class="text-center mt-2">
        <span >
            <i class="bi bi-cloud-check"></i> Protégé Cloudflare Turnstile
        </span>
    </div>

    <p class="text-center mt-2">🄯 2024-<?= date('Y') ?> <?= htmlspecialchars($appName ?? 'EasyUpload') ?></p>
</footer>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>

