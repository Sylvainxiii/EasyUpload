<div class="background">
    <div class="title">

        <h1><?= strtoupper($_ENV['FIRST_NAME'] ?? '') ?></h1>

        <div class="backgroundText">
            <?php foreach (str_split(strtoupper($_ENV['LAST_NAME'] ?? '')) as $char): ?>
                <span><?= $char ?></span>
            <?php endforeach; ?>
        </div>

    </div>
</div>

