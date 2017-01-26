<?php
/**
 * Created by PhpStorm.
 * User: awt
 * Date: 15/11/2016
 * Time: 14:45
 */

namespace models;


class User
{
    private $id,$username,$email,$color,$serviceDesk;

    public function __construct($username, $email, $color="#FF0000", $serviceDesk)
    {
        $this->username         = $username;
        $this->email            = $email;
        $this->color            = $color;
        $this->serviceDesk      = $serviceDesk;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @return mixed
     */
    public function getServiceDesk()
    {
        return $this->serviceDesk;
    }

}