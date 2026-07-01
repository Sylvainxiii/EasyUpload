<header>
    <div>
        <img src="/favicon.ico" alt="logo">
        <h1><?= strtoupper($_ENV['MAIL_FROM_NAME'] ?? 'EASYUPLOAD') ?></h1>
    </div>

    <button class="btn btn-primary btn-connexion" disabled>
        <div>Se connecter</div>
        <i class="bi bi-person-fill-lock"></i>
    </button>
</header>
