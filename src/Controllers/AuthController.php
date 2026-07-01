<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Core\View;
use PDO;
use PDOException;

class AuthController
{
    public function loginPage(Request $request): void
    {
        View::render('pages/auth', [
            'title' => 'Connexion',
            'error' => $request->query('error'),
        ]);
    }

    public function login(Request $request): void
    {
        $email = trim((string) $request->post('email', ''));
        $password = (string) $request->post('password', '');

        if ($email === '' || $password === '') {
            Response::redirect('/login?error=missing_credentials');
        }

        try {
            $pdo = new PDO('sqlite:' . PROJECT_ROOT . '/bdd.db');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException) {
            Response::redirect('/login?error=database_unavailable');
        }

        $tableExists = (bool) $pdo
            ->query("SELECT name FROM sqlite_master WHERE type = 'table' AND name = 'utilisateur'")
            ?->fetchColumn();

        if (!$tableExists) {
            Response::redirect('/login?error=auth_not_configured');
        }

        $stmt = $pdo->prepare('SELECT mail, mdp FROM utilisateur WHERE mail = :mail LIMIT 1');
        $stmt->execute(['mail' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC) ?: null;

        if (!$user || !password_verify($password, (string) $user['mdp'])) {
            Response::redirect('/login?error=invalid_credentials');
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION['mail'] = $user['mail'];

        Response::redirect('/');
    }

    public function logout(Request $request): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        unset($_SESSION['mail']);
        session_destroy();

        Response::redirect('/login');
    }
}
