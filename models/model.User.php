<?php
/**
 * Created by PhpStorm.
 * User: awt
 * Date: 15/11/2016
 * Time: 14:45
 */

namespace models;


use databaseClass;

class User implements iModels
{
    private $id,$username,$email,$color,$serviceDesk;

    /**
     * @var databaseClass $dbObj
     */
    private $dbObj;

    public function __construct($username, $email, $color="#FF0000", $serviceDesk)
    {
        $this->username         = $username;
        $this->email            = $email;
        $this->color            = $color;
        $this->serviceDesk      = $serviceDesk;
    }

    public function setDb($dbObj)
    {
        $this->dbObj = $dbObj;
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

    public function add()
    {
        // TODO: Implement add() method.
        $sql = "INSERT INTO authusers (`username`, `color`, `emailAddress`, `serviceDesk`) VALUES (?,?,?,?)";
        $this->dbObj->runQuery($sql, array(
            $this->getUsername(),
            $this->getColor(),
            $this->getEmail(),
            $this->getServiceDesk()
        ));
    }

    public function remove()
    {
        // TODO: Implement remove() method.
        $sql = "DELETE FROM authusers WHERE userID=?";
        $this->dbObj->runQuery($sql, array($this->getId()));
    }

    public function save()
    {
        // TODO: Implement save() method.
    }
}