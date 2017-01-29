<?php

/**
 * Created by PhpStorm.
 * User: awt
 * Date: 14/11/2016
 * Time: 10:10
 */

namespace models;

abstract class Templates
{
    private $location = "./templates/", $fileName;
    
    public function __construct()
    {
        $this->setLocation("./templates/");
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
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @param mixed $fileName
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;
    }
}