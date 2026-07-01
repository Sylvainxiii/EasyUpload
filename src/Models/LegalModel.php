<?php

declare(strict_types=1);

namespace App\Models;

class LegalModel
{
    public function getEditeur(array $data): object
    {
        return (object) array_merge([
            'firstName' => '',
            'lastName' => '',
            'voi' => '',
            'rue' => '',
            'codepostal' => '',
            'ville' => '',
            'departement' => '',
            'pays' => 'France',
            'tel' => '',
            'email' => '',
        ], $data);
    }

    public function getHebergeur(array $data): object
    {
        return (object) array_merge([
            'name' => '',
            'legal_form' => '',
            'registration' => '',
            'tel' => '',
            'url' => '',
        ], $data);
    }

    public function getRgpd(array $data): object
    {
        return (object) array_merge([
            'data_retention' => '',
            'log_retention' => '',
        ], $data);
    }
}
