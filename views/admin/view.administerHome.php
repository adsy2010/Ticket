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

    public function __construct($desk)
    {
        parent::__construct();
        $this->setFileName("admin/admin2.html");
        $this->userHandler = new UserHandler();
    }

    private function createOptions()
    {
        /*
        foreach ($this->userHandler->getAuthenticatedUsers() as $authenticatedUser) {
            $authenticatedUser;
        }*/
    }

    public function display()
    {
        // TODO: Implement display() method.
        return Definitions::render($this->getLocation().$this->getFileName());
    }
}