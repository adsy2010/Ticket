<?php
/**
 * Created by PhpStorm.
 * User: awt
 * Date: 12/12/2016
 * Time: 10:48
 */

namespace models;


use databaseClass;

class Cartridge implements iModels
{
    private $id, $name, $cost, $stock, $color, $printerID;

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
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * @param mixed $cost
     */
    public function setCost($cost)
    {
        $this->cost = $cost;
    }

    /**
     * @return mixed
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * @param mixed $stock
     */
    public function setStock($stock)
    {
        $this->stock = $stock;
    }

    /**
     * @return mixed
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param mixed $color
     */
    public function setColor($color)
    {
        $this->color = $color;
    }

    /**
     * @return mixed
     */
    public function getPrinterID()
    {
        return $this->printerID;
    }

    /**
     * @param mixed $printerID
     */
    public function setPrinterID($printerID)
    {
        $this->printerID = $printerID;
    }

    /**
     * Adds a Cartridge to the database associated with a Printer
     */
    public function add()
    {
        $sql = "INSERT INTO cartridge (name,cost,stock,color,printerID) VALUES (?,?,?,?,?)";
        $this->dbObj->runQuery($sql,
            array(
                $this->getName(),
                $this->getCost(),
                $this->getStock(),
                $this->getColor(),
                $this->getPrinterID()
            ));
    }

    /**
     * Updates a Cartridge in the database
     */
    public function save()
    {
        $sql = "UPDATE cartridge SET name=?, cost=?, stock=?, color=?, printerId=? WHERE id=?";
        $this->dbObj->runQuery($sql,
            array(
                $this->getName(),
                $this->getCost(),
                $this->getStock(),
                $this->getColor(),
                $this->getPrinterID(),
                $this->getId()
            ));
    }

    /**
     * Removes a Cartridge from the database
     */
    public function remove()
    {
        $sql = "DELETE FROM cartridge WHERE id=?";
        $this->dbObj->runQuery($sql, array(
            $this->getId()
        ));
    }

}