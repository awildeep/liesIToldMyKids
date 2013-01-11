<?php
namespace Lies\Entity;

use \Lies\Exception\LieException;

class LieMapper
{
    protected $_db;

    public function __construct($db)
    {
        $this->_db = $db;
    }

    public function getAll()
    {
        $sql = "
            SELECT
                *
            FROM
                lies
        ";
        $sth = $this->_db->prepare($sql);
        $sth->execute();
        $rows = $sth->fetchAll(); 

        return array_map(array($this, '_createEntityFromRow'), $rows); 
    }

    public function get($id)
    {
        $sql = "
            SELECT
                *
            FROM
                lies
            WHERE
                id = :id
        ";
        $sth = $this->_db->prepare($sql);
        $sth->execute(array(':id'=>$id));
        $row = $sth->fetch();

        if (count($row) > 0) {
            return $this->_createEntityFromRow($row);
        }

        return false;
    }

    public function getAllValid()
    {
        $sql = "
            SELECT
                *
            FROM
                lies
            WHERE
                valid=1
        ";
        $sth = $this->_db->prepare($sql);
        $sth->execute();
        $rows = $sth->fetchAll(); 

        return array_map(array($this, '_createEntityFromRow'), $rows); 
    }

    public function create(LieEntity $lieEntity)
    {
        $sql = "
            INSERT INTO
              lies
              (
                  id,
                  date,
                  description,
                  user_id,
                  valid
              )
            VALUES
              (
                  :id,
                  :date,
                  :description,
                  :user_id,
                  :valid

              )
            ";
        $sth = $this->_db->prepare($sql);
        $response = $sth->execute(array(
            ':id'           => $lieEntity->getId(),
            ':date'         => $lieEntity->getDate(),
            ':description'  => $lieEntity->getDescription(),
            ':user_id'      => $lieEntity->getUserId(),
            ':valid'        => $lieEntity->getValid()
        ));

        return $response;
    }

    public function delete($lieEntityId)
    {
        $sql = "
            DELETE FROM
                lies
            WHERE
                id = :id
        ";
        $sth = $this->_db->prepare($sql);
        $response = $sth->execute(array(':id' => $lieEntityId));

        if ($response != true) {
            throw new LieException ('Failed to delete lie record ('.$lieEntityId.')');
        }

        if ($sth->rowCount() == 1) {
            return true;
        }

        return false;
    }

    protected function _createEntityFromRow($row)
    {
        $lie = new LieEntity();
        $lie->setId($row['id']);
        $lie->setDate($row['date']);
        $lie->setDescription($row['description']);
        $lie->setUserId($row['user_id']);
        $lie->setValid($row['valid']);

        return $lie;
    }
}
