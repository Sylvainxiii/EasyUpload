<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Request;
use App\Core\View;
use App\Core\Env;

class HomeController
{
    public function index(Request $request): void
    {
        View::render('pages/home', [
            'title'       => Env::get('APP_NAME', 'EasyUpload'),
            'description' => 'Partage de fichiers simple et sécurisé.',
            'appName'     => Env::get('APP_NAME', 'EasyUpload'),
            'baseUrl'     => Env::get('APP_URL', ''),
            'method'      => $request->method(),
        ]);
    }
}
