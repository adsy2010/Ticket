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
            $u = new User($user['name'],$user['username'],$user['email'],$user['color'],$user['serviceDesk']);
            $this->addUser($u);
            //print_r($user);
        }
    }

    public function addUser(User $user)
    {
        $this->users[] = $user;
    }

    public function getAuthenticatedUsers()
    {
        //$data = $this->dbObj->runQuery("SELECT * FROM authusers");
        $data = array(
            array(
                "name" => "John Wiseman",
                "username" => "JWN1",
                "email" => "john.wiseman@mountbatten.hants.sch.uk",
                "color" => "#ff00ff",
                "serviceDesk" => 1
            ),
            array(
                "name" => "Zakir Chowdhary",
                "username" => "ZCY",
                "email" => "zakir.chowdhary@mountbatten.hants.sch.uk",
                "color" => "#00ffff",
                "serviceDesk" => 1
            )
        );
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