<?php

namespace App;

use Carbon\Carbon;

class UrlCheck
{
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function check(int $urlId): void
    {
        $sql = "INSERT INTO url_checks (url_id, created_at) VALUES (?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $urlCreated = Carbon::now()->toDateTimeString();
        $stmt->bindParam(1, $urlId);
        $stmt->bindParam(2, $urlCreated);
        $stmt->execute();
        //$id = (int) $this->pdo->lastInsertId();
    }

    public function getChecks($id)
    {
        $sql = "SELECT * FROM url_checks WHERE url_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetchAll();
    }

    public function getlastCheck($id)
    {
        $sql = "SELECT created_at FROM url_checks WHERE url_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}
