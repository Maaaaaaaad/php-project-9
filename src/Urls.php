<?php

namespace App;

class Urls
{
    private \PDO $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function save(Url $url)
    {
        $sql = "INSERT INTO urls (name, created_at) VALUES (?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $urlName = $url->getName();
        $urlCreated = $url->getCreated();
        $stmt->bindParam(1, $urlName);
        $stmt->bindParam(2, $urlCreated);
        $stmt->execute();
        $id = (int) $this->pdo->lastInsertId();
        $url->setId($id);
    }

    public function findName(string $name): array|false
    {
        $sql = "SELECT * FROM urls WHERE name = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$name]);
        return $stmt->fetch();
    }

    public function findId(string $id)
    {
        $sql = "SELECT * FROM urls WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    public function getEntities()
    {
        $sql = "SELECT * FROM urls";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    public function getID(string $name): array
    {
        $result = [];
        $sql = "SELECT id FROM urls WHERE name = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$name]);
        return $stmt->fetch();
    }
}
