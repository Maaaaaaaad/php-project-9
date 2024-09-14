<?php

namespace App;

use Carbon\Carbon;

class Url
{
    private int $id ;
    private string $name;
    private string $created;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->created = Carbon::now()->toDateTimeString();
    }


    public function getName()
    {
        return $this->name;
    }

    public function getCreated(): string
    {
        return $this->created;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

}
