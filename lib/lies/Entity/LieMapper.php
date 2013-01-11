<?php
namespace Lies\Lies\Entity;

class LieMapper
{
    protected $_db;

    public function __construct($db)
    {
        $this->_db = $db;
    }

    public function getAll()
    {
        $sql = "SELECT * FROM Lies";
        $sth = $this->_db->prepare($sql);
        $sth->execute();
        $rows = $sth->fetchAll(); 

        return array_map(array($this, '_createEntityFromRow'), $rows); 
    }

    public function get($id)
    {
        $sql = "SELECT * FROM Lies WHERE id = ?";
        $sth = $this->_db->prepare($sql);
        $sth->execute(array($id));
        $row = $sth->fetch();

        if (count($row) > 0) {
            return $this->_createEntityFromRow($row);
        }

        return false;
    }

    public function getAllValid()
    {
        $sql = "SELECT * FROM Lies WHERE valid=1";
        $sth = $this->_db->prepare($sql);
        $sth->execute();
        $rows = $sth->fetchAll(); 

        return array_map(array($this, '_createEntityFromRow'), $rows); 
    }

    public function create($lieEntity)
    {
        $sql = "
            INSERT INTO Lies
            (id, date, description, user_id, valid)
            VALUES (?, ?, ?, ?, ?)
            ";
        $sth = $this->_db->prepare($sql);
        $response = $sth->execute(array(
            $lieEntity->id,
            $lieEntity->date,
            $lieEntity->description,
            $lieEntity->user_id,
            $lieEntity->valid
        ));

        return $response;
    }

    public function delete($lieEntityId)
    {
        if ($lieEntityId == null || $lieEntityId == '') {
            return false;
        }

        $sql = "DELETE FROM Lies WHERE id = ?";
        $sth = $this->_db->prepare($sql);
        $response = $sth->execute(array($lieEntityId));

        if ($response != true) {
            return false;
        }

        if ($sth->rowCount() == 1) {
            return true;
        }

        return false;
    }

    protected function _createEntityFromRow($row)
    {
        $lie = new LieEntity();
        $lie->id = $row['id'];
        $lie->date = $row['date'];
        $lie->description = $row['description'];
        $lie->user_id = $row['user_id'];
        $lie->valid = $row['valid'];

        return $lie;
    }
}
