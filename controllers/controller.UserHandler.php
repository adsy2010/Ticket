<?php
/**
 * Created by PhpStorm.
 * User: awt
 * Date: 15/11/2016
 * Time: 14:43
 */

namespace controller;


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
            $u = new User($user['username'],$user['email'],$user['color'],$user['serviceDesk']);
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
        $sql = "INSERT INTO authusers (`username`, `color`, `emailAddress`, `serviceDesk`) VALUES (?,?,?,?)";
        $this->dbObj->runQuery($sql, array(
            $user->getUsername(),
            $user->getColor(),
            $user->getEmail(),
            $user->getServiceDesk()
        ));
    }

    public function removeUser(User $user)
    {
        $sql = "DELETE FROM authusers WHERE userID=?";
        $this->dbObj->runQuery($sql, array($user->getId()));
    }

    public function getAuthenticatedUsers()
    {
        $data = $this->dbObj->runQuery("SELECT * FROM authusers");
        /*$data = array(
            array(
                "id" => 1,
                "username" => "JWN1",
                "email" => "john.wiseman@mountbatten.hants.sch.uk",
                "color" => "#ff00ff",
                "serviceDesk" => 1
            ),
            array(
                "id" => 2,
                "username" => "ZCY",
                "email" => "zakir.chowdhary@mountbatten.hants.sch.uk",
                "color" => "#00ffff",
                "serviceDesk" => 1
            )
        );*/
        //print_r($data);
        return $data;
    }

    public function getAuthenticatedUsersTest()
    {
        //$data = $this->dbObj->runQuery("SELECT * FROM authusers");
        //print_r($data);
        //return $data;
        return array("JWN1", "ZCY", "AWT", "TRS");
    }

}