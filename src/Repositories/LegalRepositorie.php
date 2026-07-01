<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Services\SqliteService;

class LegalRepositorie
{
    public $db;

    public function __construct()
    {
        $this->db = SqliteService::getInstance();
    }

    public function getSection(string $section): array
    {
        $stmt = $this->db->query(
            "SELECT key, value FROM legal_info WHERE section = :section",
            ['section' => $section],
        );

        $result = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $result[$row['key']] = $row['value'];
        }
        return $result;
    }

    // TODO : setting with dashboard admin
}
