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
use models\Ticket;

class closedLogs extends Templates implements viewTypes
{
    private $ticketHandler;

    private $userHandler;
    
    /* @var \models\Ticket[] $tickets */
    private $tickets;

    private $tplRows = "closedTicketRows.tpl";
    private $tpl = "closedTicketHeader.tpl";

    private $desk;

    /**
     * @return mixed
     */
    public function getDesk()
    {
        return $this->desk;
    }

    public function __construct($desk)
    {
        parent::__construct();

        $this->setFileName("list.html");
        $this->ticketHandler = new ticketHandler(1);
        $this->userHandler = new UserHandler();

        $this->desk = $desk;
    }

    private function getTickets()
    {
        return $this->ticketHandler->getTickets();
    }

    private function renderAssignedUserSelectList($highlighted = null)
    {
        $template = "<option value='{ID}' {HIGHLIGHT}>{USERNAME}</option>";

        if($highlighted == null)
            $template = str_replace("{HIGHLIGHT}", "", $template);

        $authUsers = array();

        foreach ($this->userHandler->getUsers() as $user)
            if($user->getServiceDesk() == $this->getDesk()) {
                $authUsers[] = Definitions::render($template, array(
                    "ID" => $user->getId(),
                    "USERNAME" => $user->getUsername(),
                    "HIGHLIGHT" => ($highlighted == $user->getId()) ? "SELECTED" : ""
                ));
            }

        return implode("\r\n", $authUsers);
    }

    private function renderClosedLogs()
    {
        $rows = array();
        /* @var Ticket $ticket*/
        if(sizeof($this->getTickets()) > 0)
        {
            foreach ($this->getTickets() as $ticket)
            {
                if($ticket->getStatus() == 1 && $ticket->getServiceDesk() == $this->getDesk())
                {
                    //assign the easy stuff from the object
                    $data = array(
                        "LOGID"          => $ticket->getId(),
                        "LOCATION"       => $ticket->getLocation(),
                        "CONTENT"        => html_entity_decode($ticket->getContent()),
                        "CONTENTTYPE"    => $this->ticketHandler->getCategory($ticket->getContentType())->getName(),
                        "DEPARTMENT"     => $this->ticketHandler->getDepartment($ticket->getDepartment())->getDepartment(),
                        "LOGGEDBY"       => $ticket->getLoggedBy(),
                        "STATUS"         => $ticket->getStatus(),
                        "DATETIMELOGGED" => date("H:i:s ".'\o\n'." jS M Y",strtotime($ticket->getTime())),
                        "CLOSEDBY"       => $ticket->getClosedBy(),
                        "CLOSEDREASON"   => $this->ticketHandler->getCategory($ticket->getClosedReason())->getName(),
                        "CLOSEDWHY"      => $ticket->getClosedWhy(),
                        "CLOSEDDATETIME" => date("H:i:s ".'\o\n'." jS M Y",strtotime($ticket->getClosedTime()))
                    );
                    //get the comments
                    $data["COMMENTS"] = Definitions::render("templates/comments.html");

                    //display the assignation
                    $data['ASSIGNEDTO'] = (!empty($ticket->getAssignedTo()))?$this->userHandler->getUser($ticket->getAssignedTo()):"";

                    //Build the rowset
                    $row = Definitions::render($this->getLocation() . $this->tplRows, $data);
                    $rows[] = $row;

                }
            }

        }
        else
        {
            if(sizeof($rows) == 0) $rows[] = "<tr><td colspan='12'>No tickets to display</td></tr>";
        }
        return $rows;
    }

    private function posted()
    {
        if(isset($_POST['method']) && !empty($_POST['method'])) {

            $id = $_POST['id'];

            switch ($_POST['method'])
            {
                case "UPDATE":
                {
                    /**
                     * @var Ticket $ticket
                     */
                    $ticket = $this->ticketHandler->getTicket($id);

                    //dont use && !empty if you want to accept 0
                    if(isset($_POST['status']))
                        $ticket->setStatus($_POST['status']);



                    $this->ticketHandler->updateTicket($ticket);
                }
                    break;

                case "DELETE":
                {

                }
                    break;
            }
        }
    }

    public function display()
    {
        // TODO: Implement display() method.

        //if no rows have been created, generate a no row.
        if(isset($_POST)) $this->posted();

        return Definitions::render($this->getLocation() . $this->tpl, array("ROWS" => implode("\r\n",$this->renderClosedLogs())));
    }
}