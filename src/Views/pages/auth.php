<?php
$errorMessages = [
    'missing_credentials' => 'Veuillez renseigner votre e-mail et votre mot de passe.',
    'invalid_credentials' => 'Identifiants invalides.',
    'database_unavailable' => 'La base de donnees de connexion est indisponible.',
    'auth_not_configured' => 'La connexion n est pas configuree sur cette instance.',
];

$errorMessage = $errorMessages[$error ?? ''] ?? null;
?>

<?php \App\Core\View::partial('components/background'); ?>

<div class="title">
    <h1>Se connecter</h1>
</div>

<div class="form">
    <?php if ($errorMessage): ?>
        <div class="alert alert-danger" role="alert">
            <?= \App\Core\View::escape($errorMessage) ?>
        </div>
    <?php endif; ?>

    <form action="/login" method="post">
        <div class="mb-3">
            <label for="login-email" class="form-label">E-mail</label>
            <input
                required
                type="email"
                class="form-control custom-input"
                name="email"
                id="login-email"
                autocomplete="email"
            >
        </div>

        <div class="mb-3">
            <label for="login-password" class="form-label">Mot de passe</label>
            <input
                required
                type="password"
                class="form-control custom-input"
                name="password"
                id="login-password"
                autocomplete="current-password"
            >
        </div>

        <button type="submit" class="btn btn-primary">Se connecter</button>
    </form>
</div>
