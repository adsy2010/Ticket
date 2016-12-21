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
    private $name,$username,$authenticated,$color,$serviceDesk;

    public function __construct($name, $username, $color="#FF0000", $serviceDesk)
    {
        $this->name             = $name;
        $this->username         = $username;
        $this->color            = $color;
        $this->serviceDesk      = $serviceDesk;
    }

}