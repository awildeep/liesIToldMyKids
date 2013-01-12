<?php
namespace Lies\Entity;

use \Lies\Exception\UserException;

class UserMapper
{
    protected $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function get($id)
    {
        $sql = "
            SELECT
                id,
                email,
                password
            FROM
                users
            WHERE
                id = :id
            ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array(':id' => $id));
        $row = $stmt->fetch();

        if (count($row) > 0) {
            return $this->_createEntityFromRow($row);
        }

        return false;
    }

    public function create(UserEntity $userEntity)
    {


        $sql = "
            INSERT INTO
                users
                (
                    id,
                    email,
                    password
                )
            VALUES
                (
                    :id,
                    :email,
                    :password
                )
            ";
        $stmt = $this->db->prepare($sql);
        $response = $stmt->execute(
            array(
                ':id' => $userEntity->getId(),
                ':email' => $userEntity->getEmail(),
                ':password' => $userEntity->getPassword()
            )
        );

        return $response;
    }

    protected function _createEntityFromRow($row)
    {
        $user = new UserEntity();
        $user->setId($row['id']);
        $user->setEmail($row['email']);
        $user->setPassword($row['password']);

        return $user;
    }
}