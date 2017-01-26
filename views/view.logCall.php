<?php

/**
 * Created by PhpStorm.
 * User: awt
 * Date: 14/11/2016
 * Time: 10:05
 */

namespace view;
use controller\TicketHandler as ticketHandler;
use models\Definitions;
use models\Templates;

use Exception;

class logCall extends Templates implements viewTypes
{
    private $ticketHandler;
    private $desk;


    public function __construct($desk)
    {
        parent::__construct();

        $this->setFileName("log.php");
        $this->setDesk($desk);
        $this->ticketHandler = new ticketHandler();
    }

    /**
     * If the log form has been posted, then process it here
     */
    private function posted()
    {
        $finalState = "Successfully added to the database";
        try {
            //print_r($_POST);
            $serviceDesk = htmlspecialchars($_GET['desk']);
            $loggedBy = $_SESSION['username'];
            $status = 0; // 0 is open, 1 is closed
            $location = htmlspecialchars($_POST['location']);
            $content = htmlspecialchars(addslashes($_POST['content']));
            $contentType = $_POST['contentType'];
            $department = $_POST['department']; //leave blank for now
            $time = date("Y-m-d H:i:s", time());

            $vars = array(
                "serviceDesk",
                "loggedBy",
                "status",
                "location",
                "content",
                "contentType",
                "department",
            );

            foreach($vars as $var)
                if(empty($$var))
                    throw new Exception("Some submitted data is missing. The value <strong>{$var}</strong> has been flagged.");

            $this->ticketHandler->addTicket(
                $loggedBy,
                $status,
                $location,
                $content,
                $contentType,
                $department,
                $serviceDesk
            );
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

    /**
     * @param mixed $desk
     */
    private function setDesk($desk)
    {
        $this->desk = $desk;
    }

    private function getDeskName()
    {
        return ($this->getDesk() == 1) ? "itservices" : "siteservices";
    }

    public function display()
    {
        $state = ""; //set as not submitted
        if(isset($_POST) && !empty($_POST)) $state = $this->posted();
        return Definitions::render($this->getLocation().$this->getFileName(),
            array(
                "DESKNAME" => $this->getDeskName(),
                "DESK" => $this->getDesk(),
                "STATUS" => $state
            ));
    }


}