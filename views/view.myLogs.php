<?php

/**
 * Created by PhpStorm.
 * User: awt
 * Date: 14/11/2016
 * Time: 10:06
 */

namespace view;
use controller\TicketHandler as ticketHandler;
use controller\UserHandler;
use models\Definitions;
use models\Templates;

class myLogs extends Templates implements viewTypes
{
    private $ticketHandler;
    private $userHandler;
    private $tickets;

    private $tplRows = "ticketRows.tpl";
    private $tpl = "list.tpl";

    public function __construct($desk)
    {
        parent::__construct();

        $this->setFileName("list.html");
        $this->ticketHandler = new ticketHandler();
        $this->userHandler = new UserHandler();
        $this->getTickets();
    }

    private function getTickets()
    {
        $this->tickets = $this->ticketHandler->getTickets();
    }

    public function display()
    {
        // TODO: Implement display() method.
        /* @var \models\Ticket $ticket*/
        $rows = null;
        $me = "AWT";
        if(sizeof($this->tickets) > 0) {
            foreach ($this->tickets as $ticket) {
                if($ticket->getLoggedBy() == $me && $ticket->getStatus() == "open")
                {
                    //assign the easy stuff from the object
                    $data = array(
                        "LOGID"          => $ticket->getId(),
                        "LOCATION"       => $ticket->getLocation(),
                        "ASSIGNEDTO"     => $ticket->getAssignedTo(),
                        "CONTENT"        => $ticket->getContent(),
                        "CONTENTTYPE"    => $ticket->getContentType(),
                        "DEPARTMENT"     => $ticket->getDepartment(),
                        "LOGGEDBY"       => $ticket->getLoggedBy(),
                        "STATUS"         => $ticket->getStatus(),
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
        if(sizeof($rows) == 0) $rows[] = "<tr><td colspan='9'>No tickets to display</td></tr>";

        return Definitions::render($this->getLocation() . $this->tpl, array("ROWS" => implode("\r\n",$rows)));
    }
}