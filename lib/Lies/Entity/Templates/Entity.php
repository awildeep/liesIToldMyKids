<?php

namespace Lies\Entity\Templates;

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