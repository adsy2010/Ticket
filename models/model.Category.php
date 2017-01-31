<?php
/**
 * Created by PhpStorm.
 * User: awt
 * Date: 30/01/2017
 * Time: 10:29
 */

namespace models;

use databaseClass;

class Category implements iModels
{
    private $id, $name, $desk, $statusType;

    /**
     * @var databaseClass $dbObj
     */
    private $dbObj;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }


    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getDesk()
    {
        return $this->desk;
    }

    /**
     * @param mixed $desk
     */
    public function setDesk($desk)
    {
        $this->desk = $desk;
    }

    /**
     * @return mixed
     */
    public function getStatusType()
    {
        return $this->statusType;
    }

    /**
     * @param mixed $statusType
     */
    public function setStatusType($statusType)
    {
        $this->statusType = $statusType;
    }

    /**
     * Sets a database object to be used by this Category object
     *
     * @param databaseClass $dbObj
     */
    public function setDb($dbObj)
    {
        $this->dbObj = $dbObj;
    }

    /**
     * Adds current Category state to database
     */
    public function add()
    {
        $sql = "INSERT INTO categories (title, desk, statusType) VALUES (?,?,?)";
        $this->dbObj->runQuery($sql, array(
            $this->getName(),
            $this->getDesk(),
            $this->getStatusType()
        ));
    }

    /**
     * Removes current Category state from database
     */
    public function remove()
    {
        // TODO: Implement remove() method.
        $sql = "DELETE FROM categories WHERE id=?";
        $this->dbObj->runQuery($sql, array(
            $this->getId()
        ));
    }

    /**
     * Updates current Category state in database
     */
    public function save()
    {
        // TODO: Implement save() method.
        $sql = "UPDATE categories SET title=?, desk=?, statusType=? WHERE id=?";
        $this->dbObj->runQuery($sql, array(
            $this->getName(),
            $this->getDesk(),
            $this->getStatusType(),
            $this->getId()
        ));
    }
}