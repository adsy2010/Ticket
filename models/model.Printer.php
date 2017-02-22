<?php
/**
 * Created by PhpStorm.
 * User: awt
 * Date: 12/12/2016
 * Time: 10:48
 */

namespace models;


use databaseClass;

class Printer implements iModels
{
    private $id, $make, $model;

    /**
     * @var databaseClass $dbObj
     */
    private $dbObj;

    /**
     * @param databaseClass $dbObj
     */
    public function setDbObj($dbObj)
    {
        $this->dbObj = $dbObj;
    }

    public function __construct()
    {

    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getMake()
    {
        return $this->make;
    }

    /**
     * @param string $make
     */
    public function setMake($make)
    {
        $this->make = $make;
    }

    /**
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param string $model
     */
    public function setModel($model)
    {
        $this->model = $model;
    }

    /**
     * Adds a Printer to the database
     */
    public function add()
    {
        $sql = "INSERT INTO printer (make,model) VALUES (?,?)";
        $this->dbObj->runQuery($sql, array(
            $this->getMake(),
            $this->getModel()
        ));
    }

    /**
     * Updates Printer information in the database
     */
    public function save()
    {
        $sql = "UPDATE printer SET make=?, model=? WHERE id=?";
        $this->dbObj->runQuery($sql,
            array(
                $this->getMake(),
                $this->getModel(),
                $this->getId()
        ));
    }

    /**
     * Removes a Printer from the database
     */
    public function remove()
    {
        $sql = "DELETE FROM printer WHERE id=?";
        $this->dbObj->runQuery($sql,
            array(
                $this->getId()
            ));
    }
}