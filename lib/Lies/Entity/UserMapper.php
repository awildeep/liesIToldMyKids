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

    public function getAll()
    {
        $sql = "
            SELECT
                *
            FROM
                users
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll();

        return array_map(array($this, '_createEntityFromRow'), $rows);
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
                    password,
                    role
                )
            VALUES
                (
                    :id,
                    :email,
                    :password,
                    :role
                )
            ";
        $stmt = $this->db->prepare($sql);
        $response = $stmt->execute(
            array(
                ':id' => $userEntity->getId(),
                ':email' => $userEntity->getEmail(),
                ':password' => $userEntity->getPassword(),
                ':rule' => $userEntity->getRole()
            )
        );

        return $response;
    }

    public function delete($userEntityId)
    {
        $sql = "
            DELETE FROM
                users
            WHERE
                id = :id
        ";
        $stmt = $this->db->prepare($sql);
        $response = $stmt->execute(array(':id' => $userEntityId));

        if ($response != true) {
            throw new UserException ('Failed to delete user record (' . $userEntityId . ')');
        }

        if ($stmt->rowCount() == 1) {
            return true;
        }

        throw new UserException ('Multiple users deleted '.$stmt->rowCount());
    }

    protected function _createEntityFromRow($row)
    {
        $user = new UserEntity();
        $user->setId($row['id']);
        $user->setEmail($row['email']);
        $user->setPassword($row['password']);
        $user->setRole($row['role']);

        return $user;
    }
}