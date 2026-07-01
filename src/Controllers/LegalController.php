<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\View;
use App\Core\Env;
use App\Models\LegalModel;
use App\Repositories\LegalRepositorie;

class LegalController
{
    private LegalRepositorie $legalRepositorie;
    private LegalModel $legalModel;
    private object $editeur;
    private object $hebergeur;
    private object $rgpd;


    public function __construct()
    {
        $this->legalRepositorie = new LegalRepositorie();
        $this->legalModel = new LegalModel();

        $this->editeur = $this->legalModel->getEditeur(
            $this->legalRepositorie->getSection('editeur'),
        );

        $this->hebergeur = $this->legalModel->getHebergeur(
            $this->legalRepositorie->getSection('hebergeur'),
        );

        $this->rgpd = $this->legalModel->getRgpd(
            $this->legalRepositorie->getSection('rgpd'),
        );
    }

    public function legal(): void
    {
        View::render('pages/legalPage', [
            'title' => 'Mentions légales',
            'editeur' => $this->editeur,
            'hebergeur' => $this->hebergeur,
        ]);
    }

    public function privacy(): void
    {
        View::render('pages/privacyPage', [
            'title' => 'Politique de confidentialité',
            'appName' => Env::get('APP_NAME', 'EasyUpload'),
            'editeur' => $this->editeur,
            'contactEmail' => $this->editeur->email,
            'logRetention' => $this->rgpd->log_retention,
            'dataRetention' => $this->rgpd->data_retention,
        ]);
    }

    public function cgu(): void
    {
        View::render('pages/cguPage', [
            'title' => 'Conditions Générales d\'Utilisation',
            'appName' => Env::get('APP_NAME', 'EasyUpload'),
            'contactEmail' => $this->editeur->email,
            'logRetention' => $this->rgpd->log_retention,
            'dataRetention' => $this->rgpd->data_retention,
        ]);
    }

    // public function cgv(): void
    // {
    //     View::render('pages/cguPage', [
    //         //
    //     ]);
    // }
}
