<?php

/**
 * Created by PhpStorm.
 * User: awt
 * Date: 14/11/2016
 * Time: 10:06
 */

namespace view;

use controller\UserHandler;
use models\User;
use models\Definitions;
use models\Templates;

class administerHome extends Templates implements viewTypes
{
    /** @var User */
    private $userHandler;

    private $desk;

    public function __construct($desk)
    {
        parent::__construct();
        $this->setFileName("admin/admin2.html");
        $this->userHandler = new UserHandler();
        $this->desk = $desk;
    }

    private function createOptions()
    {
        /*
        foreach ($this->userHandler->getAuthenticatedUsers() as $authenticatedUser) {
            $authenticatedUser;
        }*/
        $users = $this->userHandler->getUsers();
        foreach ($users as $user)
            if($_SESSION['staff_username'] == $user->getUsername() && $_GET['desk'] == $user->getServiceDesk())
            {
                return ($_GET['desk'] == 1) ? "" : "display: none;";
            }

            return "display:none;";
    }

    public function display()
    {
        // TODO: Implement display() method.

        return Definitions::render($this->getLocation().$this->getFileName(),
            array(
                "HIDDEN" => $this->createOptions(),
                "DESK" => $this->desk
            ));
    }
}