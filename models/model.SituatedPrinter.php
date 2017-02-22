<?php
/**
 * Created by PhpStorm.
 * User: awt
 * Date: 15/02/2017
 * Time: 14:37
 */

namespace models;


use databaseClass;

class SituatedPrinter extends Printer implements iModels
{
    private $location, $exemption, $costDepartment, $printerId;

    /**
     * @return mixed
     */
    public function getPrinterId()
    {
        return $this->printerId;
    }

    /**
     * @param mixed $printerId
     */
    public function setPrinterId($printerId)
    {
        $this->printerId = $printerId;
    }

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
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param mixed $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * @return mixed
     */
    public function getExemption()
    {
        return $this->exemption;
    }

    /**
     * @param mixed $exemption
     */
    public function setExemption($exemption)
    {
        $this->exemption = $exemption;
    }

    /**
     * @return mixed
     */
    public function getCostDepartment()
    {
        return $this->costDepartment;
    }

    /**
     * @param mixed $costDepartment
     */
    public function setCostDepartment($costDepartment)
    {
        $this->costDepartment = $costDepartment;
    }

    /**
     * Adds a situated printer to the database
     */
    public function add()
    {
        $sql = "INSERT INTO situatedprinter (printerId, location, costingdepartment) VALUES (?,?,?)";
        $this->dbObj->runQuery($sql,
            array(
                $this->getPrinterId(),
                $this->getLocation(),
                $this->getCostDepartment()
            ));
    }

    /**
     * Updates a situated printer in the database
     */
    public function save()
    {
        $sql = "UPDATE situatedprinter SET printerId=?, location=?, costingdepartment=?, exemption=? WHERE id=?";
        $this->dbObj->runQuery($sql,
            array(
                $this->getPrinterId(),
                $this->getLocation(),
                $this->getCostDepartment(),
                $this->getExemption(),
                $this->getId()
            ));
    }

    /**
     * Removes a situated printer from the database
     */
    public function remove()
    {
        $sql = "DELETE FROM situatedprinter WHERE id=?";
        $this->dbObj->runQuery($sql, array(
            $this->getId()
        ));
    }
}