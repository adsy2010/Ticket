<?php

/**
 * Created by PhpStorm.
 * User: awt
 * Date: 14/11/2016
 * Time: 10:06
 */

namespace view;
use controller\TicketHandler;
use controller\UserHandler;
use models\Definitions;
use models\Templates;

class myLogs extends Templates implements viewTypes
{
    private $ticketHandler;
    private $userHandler;
    private $tickets;
    private $desk;



    private $tplRows = "myTicketRows.tpl";
    private $tpl = "myTicketHeader.tpl";

    public function __construct($desk)
    {
        parent::__construct();

        $this->setFileName("list.html");
        $this->ticketHandler = new TicketHandler();
        $this->userHandler = new UserHandler();
        $this->setDesk($desk);
    }

    /**
     * @return mixed
     */
    public function getDesk()
    {
        return $this->desk;
    }

    /**
     * @param mixed $desk
     */
    public function setDesk($desk)
    {
        $this->desk = $desk;
    }

    private function getTickets()
    {
        return $this->ticketHandler->getTickets();
    }

    public function display()
    {
        // TODO: Implement display() method.
        /* @var \models\Ticket $ticket*/
        $rows = null;


        if(sizeof($this->getTickets()) > 0) {
            foreach ($this->getTickets() as $ticket) {
                if($ticket->getLoggedBy() == $_SESSION['username'] && $ticket->getStatus() == 0 && $ticket->getServiceDesk() == $this->getDesk())
                {
                    //assign the easy stuff from the object
                    $data = array(
                        "LOGID"          => $ticket->getId(),
                        "LOCATION"       => $ticket->getLocation(),
                        "CONTENT"        => html_entity_decode($ticket->getContent()),
                        "CONTENTTYPE"    => $this->ticketHandler->getCategory($ticket->getContentType())->getName(),
                        "DATETIMELOGGED" => $ticket->getTime()
                    );
                    //get the comments
                    $data["COMMENTS"] = Definitions::render("templates/comments.html");

                    //display the assignation
                    $data['AUTHENTICATEDUSERS'] = (!empty($ticket->getAssignedTo()))?$ticket->getAssignedTo():"";

                    //Build the rowset
                    $row = Definitions::render($this->getLocation() . $this->tplRows, $data);
                    $rows[] = $row;
                }
            }
        }
        //if no rows have been created, generate a no row.
        if(sizeof($rows) == 0)
            $rows[] = "<tr><td colspan='9'>No tickets to display</td></tr>";

        return Definitions::render($this->getLocation() . $this->tpl, array("ROWS" => implode("\r\n",$rows)));
    }
}