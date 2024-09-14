<?php

namespace App;

use Carbon\Carbon;
use GuzzleHttp\Client;

class UrlCheck
{
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function setCheck(Check $check): void
    {
        $sql = "INSERT INTO url_checks (url_id, status_code ,created_at) VALUES (?,?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $urlID = $check->getUrlId();
        $statusCode = $check->getSastusCode();
        $urlCreated = $check->getCreated();
        $stmt->bindParam(1, $urlID);
        $stmt->bindParam(2, $statusCode);
        $stmt->bindParam(3, $urlCreated);
        $stmt->execute();
        $id = (int) $this->pdo->lastInsertId();
        $check->setId($id);
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
        $sql = "SELECT created_at FROM url_checks WHERE url_id = ? ORDER BY created_at DESC limit 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getStatusCode($id)
    {
        $sql = "SELECT status_code FROM url_checks WHERE url_id = ? ORDER BY created_at DESC limit 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}
