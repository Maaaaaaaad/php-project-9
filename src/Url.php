<?php

namespace App;

use Carbon\Carbon;

class Url
{
    private $id;
    private $name;
    private $created;

    public function __construct($name)
    {
        $this->name = $name;
        $this->created = Carbon::now()->toDateTimeString();
    }


    public function getName()
    {
        return $this->name;
    }

    public function getCreated()
    {
        return $this->created;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }
}
