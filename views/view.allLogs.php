<?php

/**
 * Created by PhpStorm.
 * User: awt
 * Date: 14/11/2016
 * Time: 10:05
 */

namespace view;
use controller\TicketHandler as ticketHandler;
use controller\UserHandler;
use models\Definitions;

class allLogs extends \models\Templates implements viewTypes
{
    private $ticketHandler;
    private $userHandler;
    private $tickets = array();

    private $tplRows = "ticketRows.tpl";
    private $tpl = "list.tpl";

    public function __construct($desk)
    {
        parent::__construct();
        
        $this->setFileName("list.html");
        $this->ticketHandler = new ticketHandler(null);
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
        /* @var \models\Ticket $ticket */

        $rows = null;

        //check there are tickets available to process
        if (sizeof($this->tickets) > 0) {

            foreach ($this->tickets as $ticket) {
                if ($ticket->getStatus() == "open") {

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
                    $authUsers = "<option value=\"{USER}\" {ASSIGNED}>{USER}</option>";
                    $options = array();
                    //echo json_decode("view.php?view=open", true);
                    foreach ($this->userHandler->getAuthenticatedUsersTest() as $u)
                        $options[] = Definitions::render($authUsers, array("USER" => $u, "ASSIGNED" => (!empty($ticket->getAssignedTo())&& $ticket->getAssignedTo() == $u)?"SELECTED":""));

                    $data["COMMENTS"] = Definitions::render("templates/comments.html");
                    $data["AUTHENTICATEDUSERS"] = "<select name='' id='authUser{LOGID}' onclick='event.stopPropagation()'><option value=''></option>". implode("\r\n", $options) . "</select>";
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