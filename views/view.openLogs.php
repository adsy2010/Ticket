<?php

/**
 * Created by PhpStorm.
 * User: awt
 * Date: 14/11/2016
 * Time: 10:06
 */

namespace view;
use controller\TicketHandler as ticketHandler;
use models\Definitions;
use models\Templates;

class openLogs extends Templates implements viewTypes
{
    private $ticketHandler;
    private $tickets;

    private $tplRows = "ticketRows.tpl";
    private $tpl = "list.html";

    public function __construct($desk)
    {
        parent::__construct();

        $this->ticketHandler = new ticketHandler(TRUE);
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
        $rows = array();

        if(sizeof($this->tickets) > 0) {
            foreach ($this->tickets as $ticket) {
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
                
                $row = Definitions::render($this->getLocation() . $this->tplRows, $data);
                $rows[] = $row;
            }
        }
        else $rows = "<tr><td colspan='9'>No tickets to display</td></tr>";

        return Definitions::render($this->getLocation().$this->tpl,array("ROWS" => $rows));
    }
}