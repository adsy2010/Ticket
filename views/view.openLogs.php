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

class openLogs extends Templates implements viewTypes
{
    private $ticketHandler;
    private $userHandler;
    private $tickets;
    private $desk;



    private $tplRows = "openTicketRows.tpl";
    private $tpl = "openTicketHeader.tpl";

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
            $authUsers[] = Definitions::render($template, array(
                "ID" => $user->getId(),
                "USERNAME" => $user->getUsername(),
                "HIGHLIGHT" => ($highlighted == $user->getId()) ? "SELECTED" : ""
            ));

        return implode("\r\n", $authUsers);
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

    private function renderOpenLogs()
    {
        $rows = array();

        if(sizeof($this->getTickets()) > 0) {
            foreach ($this->getTickets() as $ticket) {
                if($this->getDesk() == $ticket->getServiceDesk()) {
                    $data = array(
                        "LOGID" => $ticket->getId(),
                        "LOCATION" => $ticket->getLocation(),
                        "ASSIGNEDTO" => $this->renderAssignedUserSelectList($ticket->getAssignedTo()),
                        "CONTENT" => html_entity_decode($ticket->getContent()),
                        "CONTENTTYPE" => $this->ticketHandler->getCategory($ticket->getContentType())->getName(),
                        "DEPARTMENT" => $this->ticketHandler->getDepartment($ticket->getDepartment())->getDepartment(),
                        "LOGGEDBY" => $ticket->getLoggedBy(),
                        "STATUS" => $ticket->getStatus(),
                        "DATETIMELOGGED" => $ticket->getTime(),
                        "CLOSEREASON" => $this->renderCloseCategorySelectList()
                    );

                    $row = Definitions::render($this->getLocation() . $this->tplRows, $data);
                    $rows[] = $row;
                }
            }
        }
        if(sizeof($rows) == 0)
            $rows[] = "<tr><td colspan='9'>No tickets to display</td></tr>";

        return $rows;
    }

    public function display()
    {
        // TODO: Implement display() method.
        /* @var \models\Ticket $ticket*/

        return Definitions::render($this->getLocation().$this->tpl,array(
            "ROWS" => implode("\r\n", $this->renderOpenLogs())
        ));
    }
}