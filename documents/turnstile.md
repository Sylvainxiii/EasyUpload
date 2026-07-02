# Documentation Cloudflare Turnstile

## Étape 1 : S'inscrire sur Cloudflare

- Rendez-vous sur : <https://www.cloudflare.com/products/turnstile/>
- Créez un compte
- Validez votre email

## Étape 2 : Accéder à Turnstile

-Connectez-vous à votre dashboard <https://dash.cloudflare.com/>

- Dans le menu de gauche, cliquez sur Turnstile
- Ou accédez directement : <https://dash.cloudflare.com/?to=/:account/turnstile>
- Cliquez sur "Add widget"
- Remplissez le formulaire

   - Widget Name
   - ajouter le nom de domaine jedeploiemonappli.com
   - Widget Mode à managed


- Cliquez sur "Create"
- Voici vos clés : 1 PRIVATE : TURNSTILE_SECRET_KEY  et 1 PUBLIC : TURNSTILE_SITEKEY

## Étape 3 : Configurer le projet avec Turnstile

- voir fichier `.env_template`
- Secret Key (Clé privée) CONFIDENTIELLE - Ne jamais exposer
