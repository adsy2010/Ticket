<?php
/**
 * Created by PhpStorm.
 * User: awt
 * Date: 22/02/2017
 * Time: 13:54
 */

namespace models;


use databaseClass;

class Department implements iModels
{
    private $id, $department;

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
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * @param mixed $department
     */
    public function setDepartment($department)
    {
        $this->department = $department;
    }

    /**
     * @return databaseClass
     */
    private function getDbObj()
    {
        return $this->dbObj;
    }

    /**
     * @param databaseClass $dbObj
     */
    public function setDbObj($dbObj)
    {
        $this->dbObj = $dbObj;
    }

    public function add()
    {
        // TODO: Implement add() method.
        $sql = "INSERT INTO departments (`department`) VALUES (?)";
        $this->dbObj->runQuery($sql,
            array(
                $this->getDepartment()
            ));
    }

    public function remove()
    {
        // TODO: Implement remove() method.
        $sql = "DELETE FROM departments WHERE id=?";
        $this->dbObj->runQuery($sql,
            array(
                $this->getId()
            ));
    }

    public function save()
    {
        // TODO: Implement save() method.
        $sql = "UPDATE departments SET department=? WHERE id=?";
        $this->dbObj->runQuery($sql,
            array(
                $this->getDepartment(),
                $this->getId()
            ));
    }
}