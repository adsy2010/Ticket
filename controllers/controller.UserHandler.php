<?php
/**
 * Created by PhpStorm.
 * User: awt
 * Date: 15/11/2016
 * Time: 14:43
 */

namespace controller;


use models\Printer;
use models\User;
use databaseClass;

class UserHandler
{
    private $users = array();
    private $dbObj;

    public function __construct()
    {
        $this->dbObj = new databaseClass();
        foreach ($this->getAuthenticatedUsers() as $user)
        {
            $u = new User($user['username'],$user['emailAddress'],$user['color'],$user['serviceDesk']);
            $u->setId($user['userID']);
            $this->addAuthUser($u);
            //print_r($user);
        }
    }

    public function addAuthUser(User $user)
    {
        $this->users[] = $user;
    }

    public function addUser(User $user)
    {
        //$sql = "INSERT INTO authusers (`username`, `color`, `emailAddress`, `serviceDesk`) VALUES (?,?,?,?)";
        $user->setDb($this->dbObj); //provide a database connection for the object to use
        $user->add();
        /*$this->dbObj->runQuery($sql, array(
            $user->getUsername(),
            $user->getColor(),
            $user->getEmail(),
            $user->getServiceDesk()
        ));*/
    }

    public function removeUser(User $user)
    {
        /*$sql = "DELETE FROM authusers WHERE userID=?";
        $this->dbObj->runQuery($sql, array($user->getId()));*/
        $user->setDb($this->dbObj);
        $user->remove();
    }

    private function getAuthenticatedUsers()
    {
        $data = $this->dbObj->runQuery("SELECT * FROM authusers");
        return $data;
    }

    public function getUsers()
    {
        return $this->users;
    }


}