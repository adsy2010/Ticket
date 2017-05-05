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
use models\Ticket;

class myLogs extends Templates implements viewTypes
{
    private $ticketHandler;
    private $userHandler;
    private $tickets;
    private $desk;



    private $tplOpenRows    = "myTicketOpenRows.tpl";
    private $tplClosedRows  = "myTicketClosedRows.tpl";
    private $tpl = "myTicketHeader.tpl";
    private $tplComments = "comments.tpl";

    public function __construct($desk)
    {
        parent::__construct();

        $this->setFileName("list.html");
        $this->ticketHandler = new TicketHandler(2);
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

    private function renderCloseCategorySelectList($highlighted = null)
    {
        $template = "<option value='{ID}' {HIGHLIGHT}>{CATEGORY}</option>";

        if($highlighted == null)
            $template = str_replace("{HIGHLIGHT}", "", $template);

        $categories = array();

        foreach ($this->ticketHandler->getCategories() as $category)
            if($this->getDesk() == $category->getDesk() && $category->getStatusType() == 2)
            {
                $categories[] = Definitions::render($template, array(
                    "ID" => $category->getId(),
                    "CATEGORY" => $category->getName(),
                    "HIGHLIGHT" => ($highlighted == $category->getId()) ? "SELECTED" : ""
                ));
            }

        return implode("\r\n", $categories);
    }

    private function renderCommentRows($id)
    {
        $row = "<div> <div>{COMMENTDATETIME} by <strong>{COMMENTOR}</strong></div> <div>{COMMENT}<hr></div> </div>";

        $rows = array();

        $comments = $this->ticketHandler->getComments($id);

        if(sizeof($comments) == 0)
            $rows[] = "No comments";
        else
        {
            foreach ($comments as $comment)
            {
                $rows[] = Definitions::render($row, array(
                    "COMMENTDATETIME" => "Comment made at " . date("H:i:s ".'\o\n'." jS M Y", strtotime($comment->getCommentDateTime())),
                    "COMMENTOR" =>  $comment->getUsername(),
                    "COMMENT"   => $comment->getComment()
                ));
            }
        }


        return implode("\r\n", $rows);
    }

    private function renderComments($id)
    {
        return Definitions::render($this->getLocation() . $this->tplComments, array(
            "LOGID" => $id,
            "URL" => "open",
            "ROWS" => $this->renderCommentRows($id)
        ));
    }
    
    public function renderOpenCalls()
    {
        /* @var Ticket $ticket*/
        $rows = null;


        if(sizeof($this->getTickets()) > 0) {
            foreach ($this->getTickets() as $ticket) {
                if($ticket->getLoggedBy() == $_SESSION['username']
                    && $ticket->getStatus() == 0
                    && $ticket->getServiceDesk() == $this->getDesk()
                    || $this->userHandler->getUser($ticket->getAssignedTo()) == $_SESSION['username']
                    && $ticket->getStatus() == 0
                    && $ticket->getServiceDesk() == $this->getDesk()
                )
                {
                    //assign the easy stuff from the object
                    $data = array(
                        "LOGID"          => $ticket->getId(),
                        "LOCATION"       => $ticket->getLocation(),
                        "LOGGEDBY"      => $ticket->getLoggedBy(),
                        "COMMENTS"      => html_entity_decode($this->renderComments($ticket->getId())),
                        "CONTENT"        => html_entity_decode($ticket->getContent()),
                        "CONTENTTYPE"    => $this->ticketHandler->getCategory($ticket->getContentType())->getName(),
                        "DATETIMELOGGED" => date("H:i:s ".'\o\n'." jS M Y",strtotime($ticket->getTime())),
                        "CLOSEDREASON"    => $this->renderCloseCategorySelectList()
                    );

                    //display the assignation
                    $data['ASSIGNEDTO'] = (!empty($ticket->getAssignedTo()))?$this->userHandler->getUser($ticket->getAssignedTo()):"";

                    //Build the rowset
                    $row = Definitions::render($this->getLocation() . $this->tplOpenRows, $data);
                    $rows[] = $row;
                }
            }
        }
        //if no rows have been created, generate a no row.
        if(sizeof($rows) == 0)
            $rows[] = "<tr><td colspan='9'>No open tickets to display</td></tr>";

        return $rows;
    }

    public function renderClosedCalls()
    {
        /* @var Ticket $ticket*/
        $rows = null;


        if(sizeof($this->getTickets()) > 0) {
            foreach ($this->getTickets() as $ticket) {
                if($ticket->getLoggedBy() == $_SESSION['username']
                    && $ticket->getStatus() == 1
                    && $ticket->getServiceDesk() == $this->getDesk()
                    || $this->userHandler->getUser($ticket->getAssignedTo()) == $_SESSION['username']
                    && $ticket->getStatus() == 1
                    && $ticket->getServiceDesk() == $this->getDesk()
                )
                {
                    //assign the easy stuff from the object
                    $data = array(
                        "LOGID"          => $ticket->getId(),
                        "LOCATION"       => $ticket->getLocation(),
                        "COMMENTS"       => html_entity_decode($this->renderComments($ticket->getId())),
                        "CONTENT"        => html_entity_decode($ticket->getContent()),
                        "CONTENTTYPE"    => $this->ticketHandler->getCategory($ticket->getContentType())->getName(),
                        "DATETIMELOGGED" => date("H:i:s ".'\o\n'." jS M Y",strtotime($ticket->getTime())),
                        "CLOSEDDATETIME" => date("H:i:s ".'\o\n'." jS M Y",strtotime($ticket->getClosedTime())),
                        "CLOSEDBY"       => $ticket->getClosedBy(),
                        "CLOSEDREASON"   => $this->ticketHandler->getCategory($ticket->getClosedReason())->getName(),
                        "CLOSEDWHY"      => $ticket->getClosedWhy()
                    );
                    //display the assignation
                    $data['ASSIGNEDTO'] = (!empty($ticket->getAssignedTo()))?$this->userHandler->getUser($ticket->getAssignedTo()):"";

                    //Build the rowset
                    $row = Definitions::render($this->getLocation() . $this->tplClosedRows, $data);
                    $rows[] = $row;
                }
            }
        }
        //if no rows have been created, generate a no row.
        if(sizeof($rows) == 0)
            $rows[] = "<tr><td colspan='9'>No closed tickets to display</td></tr>";

        return $rows;
    }

    private function posted()
    {
        if (isset($_POST['method']) && !empty($_POST['method'])) {

            $id = $_POST['id'];

            switch ($_POST['method']) {
                case "UPDATE":
                {
                    /**
                     * @var Ticket $ticket
                     */
                    $ticket = $this->ticketHandler->getTicket($id);

                    //dont use && !empty if you want to accept 0
                    if(isset($_POST['closedWhy']))
                        $ticket->setClosedWhy($_POST['closedWhy']);

                    if(isset($_POST['closedReason']))
                    {
                        $ticket->setClosedReason($_POST['closedReason']);
                        $ticket->setClosedBy($_SESSION['username']);
                        $ticket->setClosedTime(date('Y-m-d H:i:s'));
                        $ticket->setStatus(1);
                    }

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

        if(isset($_POST)) $this->posted();

        return Definitions::render($this->getLocation() . $this->tpl,
            array(
                "OPENROWS" => implode("\r\n",$this->renderOpenCalls()),
                "CLOSEDROWS" => implode("\r\n", $this->renderClosedCalls())
            ));
    }
}