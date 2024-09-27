<?php
require '../vendor/autoload.php';
include_once 'dotEnv.php';
require_once 'log.php';
dotEnv("../");

$title = 'Mentions legales';

include '_header.php';

$editeur = (object) [
  'firstName' => '[firstName]',
  'lastName' => '[lastName]',
  'voi' => '[voi]',
  'rue' => '[rue]',
  'codepostal' => '[codepostal]',
  'ville' => '[ville]',
  'departement' => '[departement]',
  'pays' => 'France',
  'tel' => '[tel]',
  'email' => '[email]',
];

$hebergeur = (object) [
  'namehebergeur' => 'o2switch',
  'urlwebediteur' => 'https://easyupload.jedeploiemonappli.com/',
  'urlwebhebergeur' => 'https://www.o2switch.fr/',
  'tel' => '0444446040',
  'immatricule' => 'RCS de Clermont-Ferrand',
  'societe' => 'SAS',
];

?>

<div class="form">
  <h2>Mentions legales</h2>
  
  <div class="container-fluid w-75">

    <p><h3>Éditeur du site</h3></p>
    
    <p class="text-start mt-0">
      <b>Nom : </b><?= $editeur->firstName ?>
    </p>
    <p class="text-start mt-0">
      <b>Prénom : </b><?= $editeur->lastName ?>
    </p>
    <p class="text-start mt-0">
      <b>Adresse : </b><?= "$editeur->voi, $editeur->rue, $editeur->codepostal $editeur->ville, $editeur->departement, $editeur->pays" ?>
    </p>
    <p class="text-start mt-0">
      <b>Téléphone : </b><a class="link-light" href="tel:<?= $editeur->tel ?>"><?= $editeur->tel ?></a>
    </p>
    <p class="text-start mt-0">
      <b>Email : </b><a class="link-light" href="mailto:<?= $editeur->email ?>"><?= $editeur->email ?></a>
    </p>
    <p class="text-start mt-0">
      <b>Directeur de la publication :</b> <?= "$editeur->firstName $editeur->lastName" ?>
    </p>
  
  </div>

  <div class="container-fluid w-75">

    <hr>
    
    <p><h3>Hébergement du site</h3></p>
    
    <p class="text-start mt-0">
      Le site <a class="link-light" href="<?= $hebergeur->urlwebediteur ?>" target="_blank" rel="noopener noreferrer"><?= $hebergeur->urlwebediteur ?></a> est hébergé par <?= $hebergeur->namehebergeur ?>, société <?= $hebergeur->societe ?>,
    </p>
    <p class="text-start mt-0">
      Immatriculée au <?= $hebergeur->immatricule ?>.
    </p>
    <p class="text-start mt-0">
      Téléphone : <a class="link-light" href="tel:<?= $hebergeur->tel ?>"><?= $hebergeur->tel ?></a>
    </p>
    <p class="text-start mt-0">
      Site web : <a class="link-light" href="<?= $hebergeur->urlwebhebergeur ?>" target="_blank" rel="noopener noreferrer"><?= $hebergeur->urlwebhebergeur ?></a>
    </p>
  
    </div>

    <div class="container-fluid w-75">
    <hr>
    <p><h3>Propriété intellectuelle</h3></p>

    <p class="text-start mt-0">
      Le contenu de ce site web (textes, images, logos, etc.), sauf indication contraire, est la propriété exclusive de <?= "$editeur->firstName $editeur->lastName" ?>.
      Toute reproduction, représentation, modification, publication ou adaptation de tout ou partie des éléments de ce site est interdite, sauf autorisation écrite préalable.
    </p>

    <p class="text-start mt-0">
      Licence MIT :
    </p>

    <p class="text-start mt-0">
      Les éléments du code source utilisés dans le cadre de ce site sont mis à disposition sous la licence MIT. Vous êtes autorisé à utiliser, copier, modifier, fusionner, publier, distribuer, sous-licencier et/ou vendre des copies du logiciel, sous réserve que les conditions suivantes soient respectées :
    </p>

    <ul>
      <li>
        La mention du copyright et les avis de permission doivent être inclus dans toutes les copies ou parties substantielles du logiciel.
      </li>
      <li>
        Le logiciel est fourni "tel quel", sans garantie d'aucune sorte, explicite ou implicite, y compris, mais sans s'y limiter, les garanties de qualité marchande, d'adaptation à un usage particulier et d'absence de contrefaçon.
      </li>
    </ul>

    </div>

    <div class="container-fluid w-75">
    <hr>
    <p><h3>Responsabilité</h3></p>

    <p class="text-start mt-0">
      Les informations présentes sur ce site sont fournies à titre informatif. <?= "$editeur->firstName $editeur->lastName" ?> ne peut être tenu responsable des erreurs ou omissions, ni des dommages découlant de l'utilisation des informations fournies sur le site.
    </p>
    
    </div>

    <div class="container-fluid w-75">
    <hr>
    <p><h3>Politique de confidentialité - RGPD</h3></p>

      <p class="text-start mt-0">
        Les informations recueillies sur ce formulaire sont enregistrées dans un fichier informatisé par [identité et coordonnées du responsable de traitement] pour [finalités du traitement]. La base légale du traitement est le consentement de l'utilisateur.
      </p>

      <p class="text-start mt-0">
        Les données collectées seront communiquées aux seuls destinataires suivants : [destinataires des données].
      </p>

      <p class="text-start mt-0">
        Les données sont conservées pendant [durée de conservation des données prévue par le responsable du traitement ou critères permettant de la déterminer].
      </p>

      <p class="text-start mt-0">
        En fonction de la base légale du traitement, vous pouvez également retirer votre consentement au traitement de vos données à tout moment. Vous pouvez aussi exercer votre droit à la portabilité des données, c'est-à-dire obtenir une copie de vos données dans un format structuré et lisible par machine.
      </p>

      <p class="text-start mt-0">
        Pour toute demande relative à vos droits, merci de nous contacter à l'adresse <?= $editeur->email ?>.
      </p>

      <p class="text-start mt-0">
        Vous avez également le droit de déposer une réclamation auprès de la CNIL si vous estimez que vos droits n'ont pas été respectés.
      </p>
    </div>

</div>

<?php
include '_footer.php';
?>
