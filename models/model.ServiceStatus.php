<?php
/**
 * Created by PhpStorm.
 * User: awt
 * Date: 15/02/2017
 * Time: 11:05
 */

namespace models;


use models\iModels;

class ServiceStatus implements iModels
{

    //desk is unused at this stage

    private $name, $status, $desk;

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
    }

    public function remove()
    {
        // TODO: Implement remove() method.
    }

    public function save()
    {
        // TODO: Implement save() method.
    }
}