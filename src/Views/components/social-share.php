<?php
$url     = $shareUrl ?? '';
$text    = urlencode($shareText ?? '');
$encoded = urlencode($url);
$networks = [
    ['label' => 'Twitter / X', 'icon' => 'bi-twitter-x', 'href' => "https://twitter.com/intent/tweet?text={$text}&url={$encoded}", 'color' => 'share-twitter'],
    ['label' => 'Facebook', 'icon' => 'bi-facebook', 'href' => "https://www.facebook.com/sharer/sharer.php?u={$encoded}", 'color' => 'share-facebook'],
    ['label' => 'LinkedIn', 'icon' => 'bi-linkedin', 'href' => "https://www.linkedin.com/sharing/share-offsite/?url={$encoded}", 'color' => 'share-linkedin'],
];
?>
<section class="social-share" aria-labelledby="social-share-title">
    <p id="social-share-title" class="social-share__label">Partager le document</p>
    <ul class="social-share__list" role="list">
        <?php foreach ($networks as $network): ?>
        <li>
            <a href="<?= $network['href'] ?>" target="_blank" rel="noopener noreferrer" class="social-share__btn <?= $network['color'] ?>" aria-label="Partager sur <?= $network['label'] ?> (ouvre une nouvelle fenêtre)">
                <i class="bi <?= $network['icon'] ?>" aria-hidden="true"></i>
                <span><?= $network['label'] ?></span>
            </a>
        </li>
        <?php endforeach; ?>
    </ul>
</section>
