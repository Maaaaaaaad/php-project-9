<?php

namespace App;

use Carbon\Carbon;

class Check
{
    private int $id;
    private int $urlId;
    private int $statusCode;
    private string $h1;
    private string $title;
    private string $description;
    private string $created;

    public function __construct($id)
    {
        $this->urlId = $id;
        $this->created = Carbon::now()->toDateTimeString();
    }


    public function getCreated()
    {
        return $this->created;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getH1()
    {
        return $this->h1;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getUrlId()
    {
        return $this->urlId;
    }


    public function setCreated(string $created): void
    {
        $this->created = $created;
    }

    public function setDescription($description): void
    {
        $this->description = $description;
    }

    public function setH1($h1): void
    {
        $this->h1 = $h1;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function setStatusCode($sastusCode): void
    {
        $this->statusCode = $sastusCode;
    }

    public function setTitle($title): void
    {
        $this->title = $title;
    }

    public function setUrlId($urlId): void
    {
        $this->urlId = $urlId;
    }
}
