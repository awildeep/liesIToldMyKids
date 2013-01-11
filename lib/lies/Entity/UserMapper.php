<?php
namespace Lies\Lies\Entity;

class UserMapper
{
    protected $_db;

    public function __construct($db)
    {
        $this->_db = $db;
    }

    public function get($id)
    {
        $sql = "SELECT * FROM users WHERE id = ?";
        $sth = $this->_db->prepare($sql);
        $sth->execute(array($id));
        $row = $sth->fetch();

        if (count($row) > 0) {
            return $this->_createEntityFromRow($row);
        }

        return false;
    }

    public function create(UserEntity $userEntity)
    {
        $sql = "
            INSERT INTO users
            (id, email)
            VALUES (?, ?)
            ";
        $sth = $this->_db->prepare($sql);
        $response = $sth->execute(array(
                $userEntity->id,
                $userEntity->email
            ));

        return $response;
    }

    protected function _createEntityFromRow($row)
    {
        $user = new UserEntity();
        $user->id = $row['id'];
        $user->email = $row['email'];

        return $user;
    }
}