<?php

namespace App;

use Carbon\Carbon;

class Check
{
    private int $id;
    private int $urlId;
    private int $statusCode;
    private string|null $h1;
    private string|null $title;
    private string|null $description;
    private string $created;

    public function __construct(int $id)
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


    public function setCreated(mixed $created): void
    {
        $this->created = $created;
    }

    public function setDescription(string|null $description): void
    {
        $this->description = $description;
    }

    public function setH1(string|null $h1): void
    {
        $this->h1 = $h1;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setStatusCode(int $statusCode): void
    {
        $this->statusCode = $statusCode;
    }

    public function setTitle(string|null $title): void
    {
        $this->title = $title;
    }

    public function setUrlId(int $urlId): void
    {
        $this->urlId = $urlId;
    }
}
