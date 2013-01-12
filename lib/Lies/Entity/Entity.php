<?php

namespace Lies\Entity;

abstract class Entity
{
    private $id;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function toArray()
    {
        return get_object_vars($this);
    }
}