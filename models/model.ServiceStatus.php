<?php
/**
 * Created by PhpStorm.
 * User: awt
 * Date: 15/02/2017
 * Time: 11:05
 */

namespace models;


use databaseClass;
use models\iModels;

class ServiceStatus implements iModels
{

    //desk is unused at this stage

    private $name, $status, $desk, $oldName;

    /**
     * @return mixed
     */
    public function getOldName()
    {
        return $this->oldName;
    }

    /**
     * @param mixed $oldName
     */
    public function setOldName($oldName)
    {
        $this->oldName = $oldName;
    }

    /**
     * @var databaseClass
     */
    private $dbObj;

    /**
     * @param databaseClass $dbObj
     */
    public function setDbObj($dbObj)
    {
        $this->dbObj = $dbObj;
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
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
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

    public function add()
    {
        // TODO: Implement add() method.
        $sql = "INSERT INTO servicestatus (name) VALUES (?)";
        $this->dbObj->runQuery($sql, array(
           $this->getName()
        ));
    }

    public function remove()
    {
        // TODO: Implement remove() method.
        $sql = "DELETE FROM servicestatus WHERE name=?";
        $this->dbObj->runQuery($sql, array(
           $this->getName()
        ));
    }

    public function save()
    {
        // TODO: Implement save() method.
        //Use old name variable when passed
        $sql = "UPDATE servicestatus SET name=?, status=? WHERE name=?";
        $this->dbObj->runQuery($sql,
            array(
                $this->getName(),
                $this->getStatus(),
                $this->getOldName()
            ));
    }
}