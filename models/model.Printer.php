<?php
/**
 * Created by PhpStorm.
 * User: awt
 * Date: 12/12/2016
 * Time: 10:48
 */

namespace models;


class Printer implements iModels
{
    private $id, $location, $make, $model;

    public function __construct()
    {

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
    public function getMake()
    {
        return $this->make;
    }

    /**
     * @param mixed $make
     */
    public function setMake($make)
    {
        $this->make = $make;
    }

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param mixed $model
     */
    public function setModel($model)
    {
        $this->model = $model;
    }

    public function add()
    {
        $sql = "INSERT INTO printer (make,model,location) VALUES (?,?,?)";
    }

    public function save()
    {
        $sql = "UPDATE printer SET make=?, model=?, location=? WHERE id=?";
    }

    public function remove()
    {
        $sql = "DELETE FROM printer WHERE id=?";
    }
}