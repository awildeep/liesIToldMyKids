<?php
namespace Lies\Entity;

use Lies\Exception\UserException;
use Lies\Entity\Entity;

class UserEntity extends Entity
{
    private $id;
    private $email;
    private $password;
    private $role;


    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        if ($id == null || !is_integer($id)) {
            throw new UserException ('Invalid ID ('.$id.')');
        }

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

    public function toArray() {
        return get_object_vars($this);
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role)
    {
        if ($role === null || trim($role) == '') {
            throw new UserException('Invalid role (' . $role . ').');
        }
        $this->role = $role;
    }
}
