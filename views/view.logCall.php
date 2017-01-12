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

class logCall extends Templates implements viewTypes
{
    private $ticketHandler;

    public function __construct($desk)
    {
        parent::__construct();

        $this->setFileName("log.php");
        $this->ticketHandler = new ticketHandler();
    }

    /**
     * If the log form has been posted, then process it here
     */
    private function posted()
    {
        $serviceDesk = htmlspecialchars($_GET['desk']);
        $time = date("Y-m-d H:i:s", time());

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

    public function display()
    {

        return Definitions::render($this->getLocation().$this->getFileName(),
            array(
                "DESKNAME" => "itservices",
                "DESK" => 1,
                "STATUS" => ""
            ));
    }


}