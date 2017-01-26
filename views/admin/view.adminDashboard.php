<?php
/**
 * Created by PhpStorm.
 * User: awt
 * Date: 24/01/2017
 * Time: 13:10
 */

namespace view;
use controller\UserHandler;
use models\Definitions;
use models\Templates;

class adminDashboard extends Templates implements viewTypes
{
    private $userHandler;
    /**
     * @var
     */
    private $authUsers;
    private $desk;

    public function __construct($desk)
    {
        parent::__construct();
        $this->setFileName("admin/dashboard.htm");
        $this->userHandler = new UserHandler();
        $this->setDesk($desk);
        $this->setAuthUsers($this->userHandler->getAuthenticatedUsers());
    }

    /**
     * @return array
     */
    private function getAuthUsers()
    {
        return $this->authUsers;
    }

    /**
     * @param array $authUsers
     */
    private function setAuthUsers($authUsers)
    {
        $this->authUsers = $authUsers;
    }

    /**
     * @return mixed
     */
    private function getDesk()
    {
        return $this->desk;
    }

    /**
     * @param mixed $desk
     */
    private function setDesk($desk)
    {
        $this->desk = $desk;
    }

    private function renderAuthUsers()
    {
        $authUsersTpl = Definitions::render($this->getLocation()."admin/authUser.tpl");
        $authUsersList = array();
        foreach ($this->getAuthUsers() as $authUser)
        {
            $authUsersList[] = Definitions::render($authUsersTpl,
                array(
                    "ID" => $authUser['id'],
                    "USERNAME" => $authUser['username'],
                    "EMAILADDRESS" => $authUser['email'],
                    "COLOR" => $authUser['color']
                ));
        }

        return (!empty($authUsersList)) ? implode("\r\n", $authUsersList) : "";
    }

    public function display()
    {
        $template = Definitions::render($this->getLocation().$this->getFileName(),
            array(
                "AUTHUSERS" => $this->renderAuthUsers(),
                "DESK" => $this->getDesk()
                ));

        return $template;
    }
}