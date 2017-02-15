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
    private $id, $make, $model;

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