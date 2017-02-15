<?php
/**
 * Created by PhpStorm.
 * User: awt
 * Date: 15/02/2017
 * Time: 14:37
 */

namespace models;


class SituatedPrinter extends Printer implements iModels
{
    private $location, $exemption, $costDepartment;

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

    public function add()
    {

    }

    public function save()
    {

    }

    public function remove()
    {

    }
}