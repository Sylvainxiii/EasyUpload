<?php

namespace App\Services;

class TurnstileService
{
    private $secretKey;
    private $siteKey;

    public function __construct()
    {
        $this->secretKey = $_ENV['TURNSTILE_SECRET_KEY'] ?? '';
        $this->siteKey = $_ENV['TURNSTILE_SITEKEY'] ?? '';
    }

    public function getSiteKey()
    {
        return $this->siteKey;
    }

    public function validateToken($token, $remoteip = null)
    {
        if (empty($token)) {
            return false;
        }

        $url = 'https://challenges.cloudflare.com/turnstile/v0/siteverify';

        $data = [
            'secret' => $this->secretKey,
            'response' => $token,
        ];

        if ($remoteip) {
            $data['remoteip'] = $remoteip;
        }

        $options = [
            'http' => [
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data),
                'timeout' => 10,
            ],
        ];

        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);

        if ($response === false) {
            return false;
        }

        $result = json_decode($response, true);
        return $result['success'] ?? false;
    }

    public function getClientIp()
    {
        return $_SERVER['HTTP_CF_CONNECTING_IP']
            ?? $_SERVER['HTTP_X_FORWARDED_FOR']
            ?? $_SERVER['REMOTE_ADDR'];
    }

    public function isVerified()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['turnstile_verified']) && $_SESSION['turnstile_verified'] === true) {
            if (isset($_SESSION['turnstile_verified_time']) && (time() - $_SESSION['turnstile_verified_time']) < 86400) {
                return true;
            }
        }

        return false;
    }

    public function setVerified()
    {
        $_SESSION['turnstile_verified'] = true;
        $_SESSION['turnstile_verified_time'] = time();
    }

    public function clearVerification()
    {
        unset($_SESSION['turnstile_verified']);
        unset($_SESSION['turnstile_verified_time']);
    }
}
