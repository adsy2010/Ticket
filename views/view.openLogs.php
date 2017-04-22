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
use models\Category;
use models\Definitions;
use models\Templates;
use models\Ticket;

class openLogs extends Templates implements viewTypes
{
    private $ticketHandler;
    private $userHandler;
    private $tickets;
    private $desk;



    private $tplRows = "openTicketRows.tpl";
    private $tpl = "openTicketHeader.tpl";
    private $tplComments = "comments.tpl";

    public function __construct($desk)
    {
        parent::__construct();

        $this->ticketHandler = new TicketHandler();
        $this->userHandler = new UserHandler();
        $this->setDesk($desk);

    }

    private function getTickets()
    {
        return $this->ticketHandler->getTickets();
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

    private function renderCloseCategorySelectList($highlighted = null)
    {
        $template = "<option value='{ID}' {HIGHLIGHT}>{CATEGORY}</option>";

        if($highlighted == null)
            $template = str_replace("{HIGHLIGHT}", "", $template);

        $categories = array();

        /** @var Category $category */
        foreach ($this->ticketHandler->getCategories() as $category)
        {
            if ($this->getDesk() == $category->getDesk() && $category->getStatusType() == 2) {
                $categories[] = Definitions::render($template, array(
                    "ID" => $category->getId(),
                    "CATEGORY" => $category->getName(),
                    "HIGHLIGHT" => ($highlighted == $category->getId()) ? "SELECTED" : ""
                ));
            }
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

    private function renderOpenLogs()
    {
        $rows = array();

        if(sizeof($this->getTickets()) > 0) {
            foreach ($this->getTickets() as $ticket) {
                if($this->getDesk() == $ticket->getServiceDesk() && $ticket->getStatus() == 0) {
                    $data = array(
                        "LOGID"         => $ticket->getId(),
                        "LOCATION"      => $ticket->getLocation(),
                        "COMMENTS"      => html_entity_decode($this->renderComments($ticket->getId())),
                        "ASSIGNEDTO"    => $this->renderAssignedUserSelectList($ticket->getAssignedTo()),
                        "CONTENT"       => html_entity_decode($ticket->getContent()),
                        "CONTENTTYPE"   => $this->ticketHandler->getCategory($ticket->getContentType())->getName(),
                        "DEPARTMENT"    => $this->ticketHandler->getDepartment($ticket->getDepartment())->getDepartment(),
                        "LOGGEDBY"      => $ticket->getLoggedBy(),
                        "STATUS"        => $ticket->getStatus(),
                        "DATETIMELOGGED" => date("H:i:s ".'\o\n'." jS M Y",strtotime($ticket->getTime())),
                        "CLOSEDREASON"  => $this->renderCloseCategorySelectList(),
                        "HIGH"          => ($ticket->getPriority() == 3) ? "checked=checked":"",
                        "MEDIUM"        => ($ticket->getPriority() == 2) ? "checked=checked":"",
                        "LOW"           => ($ticket->getPriority() == 1) ? "checked=checked":"",
                    );

                    $row = Definitions::render($this->getLocation() . $this->tplRows, $data);
                    $rows[] = $row;
                }
            }
        }
        if(sizeof($rows) == 0)
            $rows[] = "<tr><td colspan='10'>No tickets to display</td></tr>";

        return $rows;
    }

    /**
     *
     */
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
                    if(isset($_POST['assignedTo']))
                        $ticket->setAssignedTo($_POST['assignedTo']);

                    if(isset($_POST['closedWhy']))
                        $ticket->setClosedWhy($_POST['closedWhy']);

                    if(isset($_POST['priority']))
                        $ticket->setPriority($_POST['priority']);

                    if(isset($_POST['closedReason']))
                    {
                        $ticket->setClosedReason($_POST['closedReason']);
                        $ticket->setClosedBy($_SESSION['username']);
                        $ticket->setClosedTime(date('Y-m-d H:i:s'));
                        $ticket->setStatus(1);
                    }

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
        /* @var \models\Ticket $ticket*/

        if(isset($_POST)) $this->posted();

        return Definitions::render($this->getLocation().$this->tpl,array(
            "ROWS" => implode("\r\n", $this->renderOpenLogs())
        ));
    }
}