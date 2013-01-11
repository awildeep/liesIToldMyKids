<?php
namespace Lies\Entity;

use Lies\Exception\LieException;

class LieEntity
{
    private $id;
    private $date;
    private $description;
    private $user_id;
    private $valid;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        if ($id == null || $id == '') {
            throw new LieException ('Invalid $lieEntityId ('.$id.')');
        }

        $this->id = $id;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        //A description should be at least 3 characters
        if(strlen($description) < 3) {
            throw new LieException ('Invalid description ('.$description.')');
        }

        $this->description = $description;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    public function getValid()
    {
        return $this->valid;
    }

    public function setValid($valid)
    {
        $this->valid = $valid;
    }
}
