<?php

/**
 * Created by PhpStorm.
 * User: awt
 * Date: 14/11/2016
 * Time: 10:05
 */

namespace view;

use controller\TicketHandler as ticketHandler;
use models\Category;
use models\Definitions;
use models\Department;
use models\Templates;

use Exception;
use models\Ticket;

class logCall extends Templates implements viewTypes
{
    private $ticketHandler;
    private $desk;

    private $savedTicket;

    public function __construct($desk)
    {
        parent::__construct();

        $this->setFileName("log.php");
        $this->setDesk($desk);
        $this->ticketHandler = new ticketHandler();
    }


    /**
     * @return Ticket
     */
    public function getSavedTicket()
    {
        return $this->savedTicket;
    }

    /**
     * @param mixed $savedTicket
     */
    public function setSavedTicket($savedTicket)
    {
        $this->savedTicket = $savedTicket;
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
                "location",
                "content",
                "contentType",
                "department",
            );
            print_r($_POST);

            $ticket = new Ticket();
            $ticket->setLoggedBy($loggedBy);
            $ticket->setStatus($status);
            $ticket->setLocation($location);
            $ticket->setContent($content);
            $ticket->setContentType($contentType);
            $ticket->setDepartment($department);
            $ticket->setServiceDesk($serviceDesk);

            $this->setSavedTicket($ticket); //only used if something goes wrong

            foreach($vars as $var)
                if(!isset($$var) || empty($$var))
                    throw new Exception("Some submitted data is missing. The value <strong>{$var}</strong> has been flagged.");


            //time not required, worked out by MySQL

            //status not required, default value in place

            $this->setSavedTicket(null);

            /*
            $this->ticketHandler->addTicket(
                $loggedBy,
                $status,
                $location,
                $content,
                $category,
                $department,
                $serviceDesk
            );*/
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

    private function renderCatList()
    {
        $catRowTpl = Definitions::render("<option name={NAME} value={VALUE}>{NAME}</option>");
        $catRowList = array();

        foreach ($this->ticketHandler->getCategories($this->getDesk()) as $category)
        {
            /** @var Category $category */
            if($category->getStatusType() == 1) {
                $catRowList[] = Definitions::render($catRowTpl,
                    array(
                        "VALUE" => $category->getId(),
                        "NAME" => $category->getName(),
                    ));
            }
        }

        return (!empty($catRowList)) ? implode("\r\n", $catRowList) : "";
    }

    private function renderDeptsList()
    {
        $deptRowTpl = Definitions::render("<option name={NAME} value={VALUE}>{NAME}</option>");
        $deptRowList = array();

        foreach ($this->ticketHandler->getDepartments() as $department)
        {
            /** @var Department $category */
            $deptRowList[] = Definitions::render($deptRowTpl,
                array(
                    "VALUE" => $department->getId(),
                    "NAME" => $department->getDepartment(),
                ));
        }

        return (!empty($deptRowList)) ? implode("\r\n", $deptRowList) : "";
    }

    public function display()
    {
        $state = ""; //set as not submitted
        if(isset($_POST) && !empty($_POST)) $state = $this->posted();

        return Definitions::render($this->getLocation().$this->getFileName(),
            array(
                "DESKNAME" => $this->getDeskName(),
                "DESK" => $this->getDesk(),
                "STATUS" => $state,
                "CATEGORIES" => $this->renderCatList(),
                "USERNAME" => $_SESSION['username'],
                "DEPARTMENTS" => $this->renderDeptsList(),
                "CONTENT" => ($this->getSavedTicket() != null)? $this->getSavedTicket()->getContent() : ""
            ));

    }


}