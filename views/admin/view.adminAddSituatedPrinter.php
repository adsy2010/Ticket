<?php
/**
 * Created by PhpStorm.
 * User: awt
 * Date: 25/01/2017
 * Time: 14:55
 */

namespace view;

use controller\UserHandler;
use controllers\PrinterHandler;
use Exception;
use models\Definitions;
use models\Templates;
use models\User;

class adminAddSituatedPrinter extends Templates implements viewTypes
{
    private $desk;
    private $printerHandler;

    public function __construct($desk)
    {
        parent::__construct();
        $this->setDesk($desk);
        $this->setFileName("admin/addSituatedPrinter.htm");
        $this->printerHandler = new PrinterHandler();
    }

    /**
     * @param mixed $desk
     */
    private function setDesk($desk)
    {
        $this->desk = $desk;
    }

    private function posted()
    {
        $finalState = "Successfully added to the database";
        try
        {
            /*
            $username = $_POST['username'];
            $emailAddress = $_POST['emailAddress'];
            $userCol = $_POST['userCol'];
            $desk = $_POST['desk'];

            $vars = array(
                "username",
                "emailAddress",
                "userCol"
            );

            foreach($vars as $var)
                if(empty($$var))
                    throw new Exception("Some submitted data is missing. The value <strong>{$var}</strong> has been flagged.");

            $this->userHandler->addUser(new User($username,$emailAddress,$userCol,$desk));
            */
        }
        catch (Exception $e)
        {
            $finalState = $e->getMessage();
        }
        return $finalState;
    }

    /**
     * @return mixed
     */
    private function getDesk()
    {
        return $this->desk;
    }

    public function display()
    {
        // TODO: Implement display() method.
        $state = ""; //set as not submitted
        if(isset($_POST) && !empty($_POST)) $state = $this->posted();

        //print_r($_POST);

        return Definitions::render($this->getLocation().$this->getFileName(),
            array(
                "STATUS" => $state,
                "DESK" => $this->getDesk()
            )
        );

    }
}