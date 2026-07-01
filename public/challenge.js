async function onSuccess(token) {
  console.log('Challenge Success:', token);

  const statusDiv = document.getElementById('status');
  statusDiv.innerHTML = '<span class="loader"></span> Vérification en cours...';

  try {
    const response = await fetch("/challenge", {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: 'cf-turnstile-response=' + encodeURIComponent(token)
    });

    const data = await response.json();

    if (data.success) {
      statusDiv.innerHTML = '✅ Vérification réussie ! Redirection...';
      window.location.href = data.redirect;
    } else {
      statusDiv.innerHTML = '❌ Échec de la vérification. Veuillez réessayer.';
      turnstile.reset();
    }
  } catch (error) {
    console.error(error);
    statusDiv.innerHTML = '❌ Erreur technique. Veuillez rafraîchir la page.';
    turnstile.reset();
  }
}

function onError(errorCode) {
  console.log('Challenge Error:', errorCode);
}

function onExpired() {
  console.log('Token expired');
}

function onTimeout() {
  console.log('Challenge timed out');
}
