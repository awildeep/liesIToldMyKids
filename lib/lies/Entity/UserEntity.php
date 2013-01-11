<?php
namespace Lies\Entity;

use Lies\Exception\UserException;

class UserEntity
{
    private $id;
    private $email;
    private $password;


    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        if ((trim($email) == '') || (!filter_var($email, FILTER_VALIDATE_EMAIL))) {
            throw new UserException('Invalid email address (' . $email . ').');
        }
        $this->email = $email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        if (trim($password) == '') {
            throw new UserException('Invalid password (' . $password . ').');
        }
        $this->password = $password;
    }
}
