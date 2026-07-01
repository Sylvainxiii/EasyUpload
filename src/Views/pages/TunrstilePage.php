<div class="grid text-center">
  <div>
    <div class="cf-turnstile"
      data-sitekey="<?= $_ENV['TURNSTILE_SITEKEY'] ?>"
      data-callback="onSuccess"
      data-error-callback="onError"
      data-expired-callback="onExpired"
      data-timeout-callback="onTimeout">
    </div>
    <div id="status" class="status-message status-loading">
      ⏳ En attente de vérification...
    </div>

  </div>
  <script src='/challenge.js'></script>
</div>
