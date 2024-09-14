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

    public function getSastusCode()
    {
        return $this->sastusCode;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getUrlId()
    {
        return $this->urlId;
    }


    public function setCreated(string $created)
    {
        $this->created = $created;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function setH1($h1)
    {
        $this->h1 = $h1;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setStatusCode($sastusCode)
    {
        $this->sastusCode = $sastusCode;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setUrlId($urlId)
    {
        $this->urlId = $urlId;
    }
}
