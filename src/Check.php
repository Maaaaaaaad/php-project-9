<?php

namespace App;

use Carbon\Carbon;

class Check
{
    private $id;
    private $urlId;

    private $sastusCode;
    private $h1;
    private $title;

    private $description;
    private $created;

    public function __construct($id)
    {
        $this->urlId = $id;
        $this->created = Carbon::now()->toDateTimeString();
    }


    /**
     * @return string
     */
    public function getCreated(): string
    {
        return $this->created;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getH1()
    {
        return $this->h1;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getSastusCode()
    {
        return $this->sastusCode;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getUrlId()
    {
        return $this->urlId;
    }

    /**
     * @param string $created
     */
    public function setCreated(string $created): void
    {
        $this->created = $created;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @param mixed $h1
     */
    public function setH1($h1): void
    {
        $this->h1 = $h1;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @param mixed $sastusCode
     */
    public function setSastusCode($sastusCode): void
    {
        $this->sastusCode = $sastusCode;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @param mixed $urlId
     */
    public function setUrlId($urlId): void
    {
        $this->urlId = $urlId;
    }
}
