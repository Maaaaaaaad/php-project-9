<?php

namespace App;

use Carbon\Carbon;
use GuzzleHttp\Client;

class UrlCheck
{
    private \PDO $pdo;

    /**
     * Подключение к базе данных и возврат экземпляра объекта \PDO
     * @return \PDO
     * @throws \Exception
     */

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function setCheck(Check $check): void
    {
        $sql = "INSERT INTO url_checks (url_id, status_code, h1, title, description, created_at) 
        VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);

        $urlID = $check->getUrlId();
        $statusCode = $check->getStatusCode();
        $h1 = $check->getH1();
        $urlCreated = $check->getCreated();
        $title = $check->getTitle();
        $description = $check->getDescription();

        $stmt->bindParam(1, $urlID);
        $stmt->bindParam(2, $statusCode);
        $stmt->bindParam(3, $h1);
        $stmt->bindParam(4, $title);
        $stmt->bindParam(5, $description);
        $stmt->bindParam(6, $urlCreated);
        $stmt->execute();

        $id = (int) $this->pdo->lastInsertId();
        $check->setId($id);
    }

    public function getChecks(int $id): null|array
    {
        $sql = "SELECT * FROM url_checks WHERE url_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetchAll();

        foreach ($result as $value) {
            $course = $value;
            $end[] = $course;
        }
        return $end;
    }

    public function getlastCheck(int $id): mixed
    {
        $sql = "SELECT created_at FROM url_checks WHERE url_id = ? ORDER BY created_at DESC limit 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getStatusCode(int $id): mixed
    {
        $sql = "SELECT status_code FROM url_checks WHERE url_id = ? ORDER BY created_at DESC limit 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}
