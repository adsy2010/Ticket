<?php
/**
 * Created by PhpStorm.
 * User: awt
 * Date: 15/11/2016
 * Time: 14:43
 */

namespace controller;


use models\User;

class UserHandler
{
    private $users = array();
    private $dbObj;

    public function __construct()
    {
        $this->dbObj = new \databaseClass();
        foreach ($this->getAuthenticatedUsers() as $user)
        {
            $u = new User($user['name'],$user['username'],$user['color'],$user['serviceDesk']);
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
        $data = $this->dbObj->runQuery("SELECT * FROM authusers");
        //print_r($data);
        return $data;
        //return array("JWN1", "ZCY", "AWT", "TRS");
    }

    public function getAuthenticatedUsersTest()
    {
        //$data = $this->dbObj->runQuery("SELECT * FROM authusers");
        //print_r($data);
        //return $data;
        return array("JWN1", "ZCY", "AWT", "TRS");
    }

}