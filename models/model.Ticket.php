<?php

/**
 * Created by PhpStorm.
 * User: awt
 * Date: 25/10/2016
 * Time: 12:32
 */

namespace models;

use controller\TicketHandler;
use controller\UserHandler;
use models\Category;
use databaseClass;
use Exception;

class Ticket implements iModels
{
    private $time, $loggedBy, $assignedTo, $id, $location, $status,
            $contentType, $content, $department, $serviceDesk,
            $closedBy, $closedWhy, $closedReason, $closedTime, $priority;

    /** @var  UserHandler $userHandler */
    private $userHandler;


    //This is used to determine what emails to send
    //1: New Ticket
    //2: Assigned to Ticket
    //3: Updated Ticket (Comments)
    //4: Closed Ticket
    ////////5: Reopened Ticket Maybe
    private $trigger;



    /** @var Comment[] */
    private $comments = array();

    /**
     * @var databaseClass $dbObj
     */
    private $dbObj;

    /**
     * @return mixed
     */
    public function getClosedWhy()
    {
        return $this->closedWhy;
    }

    /**
     * @param mixed $closedWhy
     */
    public function setClosedWhy($closedWhy)
    {
        $this->closedWhy = $closedWhy;
    }

    /**
     * @return mixed
     */
    public function getTrigger()
    {
        return $this->trigger;
    }

    /**
     * @param mixed $trigger
     */
    private function setTrigger($trigger)
    {
        $this->trigger = $trigger;
    }

    /**
     * @return databaseClass
     */
    private function getDbObj()
    {
        return $this->dbObj;
    }

    /**
     * @param mixed $dbObj
     */
    public function setDbObj($dbObj)
    {
        $this->dbObj = $dbObj;
        $this->userHandler = new UserHandler();
    }

    /**
     * @return mixed
     */
    public function getServiceDesk()
    {
        return $this->serviceDesk;
    }

    /**
     * @param mixed $serviceDesk
     */
    public function setServiceDesk($serviceDesk)
    {
        $this->serviceDesk = $serviceDesk;
    }

    /**
     * @return mixed
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * @param mixed $department
     */
    public function setDepartment($department)
    {
        $this->department = $department;
    }

    /**
     * @return mixed
     */
    public function getContentType()
    {
        return $this->contentType;
    }

    /**
     * @param mixed $contentType
     */
    public function setContentType($contentType)
    {
        $this->contentType = $contentType;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }
    
    /**
     * @return array
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }
    
    /**
     * @return mixed
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param mixed $time
     */
    public function setTime($time)
    {
        $this->time = $time;
    }

    /**
     * @return mixed
     */
    public function getLoggedBy()
    {
        return $this->loggedBy;
    }

    /**
     * @param mixed $loggedBy
     */
    public function setLoggedBy($loggedBy)
    {
        $this->loggedBy = $loggedBy;
    }

    /**
     * @return mixed
     */
    public function getAssignedTo()
    {
        return $this->assignedTo;
    }

    /**
     * @param mixed $assignedTo
     */
    public function setAssignedTo($assignedTo)
    {
        $this->assignedTo = $assignedTo;
        $this->setTrigger(2);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param mixed $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * @return array
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param array $comments
     */
    public function setComments($comments)
    {
        $this->comments = $comments;
    }

    /**
     * @return mixed
     */
    public function getClosedBy()
    {
        return $this->closedBy;
    }

    /**
     * @param mixed $closedBy
     */
    public function setClosedBy($closedBy)
    {
        $this->closedBy = $closedBy;
        $this->setTrigger(4);
    }

    /**
     * @return mixed
     */
    public function getClosedReason()
    {
        return $this->closedReason;
    }

    /**
     * @param mixed $closedReason
     */
    public function setClosedReason($closedReason)
    {
        $this->closedReason = $closedReason;
        $this->setTrigger(4);
    }

    /**
     * @return mixed
     */
    public function getClosedTime()
    {
        return $this->closedTime;
    }

    /**
     * @param mixed $closedTime
     */
    public function setClosedTime($closedTime)
    {
        $this->closedTime = $closedTime;
        $this->setTrigger(4);
    }

    /**
     * @return mixed
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @param mixed $priority
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
        $this->setTrigger(3);
    }

    public function add()
    {
        if(!empty($this->getId()))
            throw new Exception("Cannot add ticket to database as ticket is already in the database.");

        $sql = "INSERT INTO tickets (`loggedBy`,`content`,`contentType`,`department`,`location`,`status`,`serviceDesk`, `priority`) VALUES(?,?,?,?,?,?,?,?)";
        $arr = array(   $this->getLoggedBy(),
                        $this->getContent(),
                        $this->getContentType(),
                        $this->getDepartment(),
                        $this->getLocation(),
                        $this->getStatus(),
                        $this->getServiceDesk(),
                        $this->getPriority()
        );

        $this->getDbObj()->runQuery($sql, $arr);//$this->email(0);
        $this->setTrigger(1);
        $this->setTime(date("Y-m-d H:i:s", time()));
        $this->email();
    }

    //archive
    public function remove()
    {
        if($this->getStatus() != 1)
            throw new Exception("Ticket has not been archived and cannot be closed.");
        if(empty($this->getClosedReason()))
            throw new Exception("Please ensure a closure reason is selected.");
        $sql = "UPDATE tickets SET status=?, closedBy=?, closedReason=?, closedTime=? WHERE logId=?";
        //$this->email(1); //send closure email
    }

    //allow unarchive etc
    public function save()
    {
        //if the changer is the current user, allow edits to content?
        $sql = "UPDATE tickets SET status=?, assignedTo=?, closedBy=?, closedReason=?, closedTime=?, closedWhy=?, priority=? WHERE logId=?";
        $this->dbObj->runQuery($sql, array(
            $this->getStatus(),
            $this->getAssignedTo(),
            $this->getClosedBy(),
            $this->getClosedReason(),
            $this->getClosedTime(),
            $this->getClosedWhy(),
            $this->getPriority(),
            $this->getId()
        ));

        $this->email();
    }

    private function pullTemplate($templates,$state)
    {
        $ticketHandler = new TicketHandler("x");
        $content = Definitions::render("templates/emails/{$templates[$state]['TEMPLATE']}",
            array(
                "LOGGEDBY"          => $this->getLoggedBy(),
                "LOGGEDDATETIME"    => $this->getTime(),
                "LOCATION"          => $this->getLocation(),
                "CONTENT"           => html_entity_decode($this->getContent()),
                "RESOLUTION"        => ($this->getClosedReason() != null) ? $ticketHandler->getCategory($this->getClosedReason())->getName() : "",
                "WHY"               => $this->getClosedWhy(),
                "RESOLVEDBY"        => $this->getClosedBy(),
                "RESOLVEDDATETIME"  => $this->getClosedTime(),
                "ASSIGNEDTO"        => $this->userHandler->getUser($this->getAssignedTo()),
                "ASSIGNEDBY"        => $_SESSION["username"],
                "UPDATEDBY"         => $_SESSION["username"],
                "UPDATEDTIME"       => date("H:i:s ".'\o\n'." jS M Y", time()),
                "ID"                => $this->getId()
            ));

        return $content;
    }

    private function renderSubject($templates, $state)
    {
        $content = Definitions::render("{$templates[$state]["SUBJECTLINE"]}",
            array(
                "USERNAME"          => $this->getLoggedBy(),
                "ASSIGNEE"          => $this->userHandler->getUser($this->getAssignedTo()),
                "ID"                => $this->getId()
            ));

        return $content;
    }

    /**
     * Sends emails to authorised users and user who logged the call
     *
     * @param int $type Set to 1 if call is resolved
     */
    private function email()
    {
        //RESOLVED LOGGED UPDATED ASSIGNED
        $templates = array(
            "RESOLVED"  => array(
                "TEMPLATE" => "resolvedEmail.htm",
                "SUBJECTLINE" => "RESOLVED - Helpdesk call ID #{ID} by {USERNAME}"
            ),
            "LOGGED"    => array(
                "TEMPLATE" => "logEmail.htm",
                "SUBJECTLINE" => "LOGGED - Helpdesk call ID #{ID} by {USERNAME}"
            ),
            "UPDATED"   => array(
                "TEMPLATE" => "updatedEmail.htm",
                "SUBJECTLINE" => "UPDATED - Helpdesk call ID #{ID} by {USERNAME}"
            ),
            "ASSIGNED"  => array(
                "TEMPLATE" => "assignedEmail.htm",
                "SUBJECTLINE" => "ASSIGNED - Helpdesk call ID #{ID} to {ASSIGNEE}"
            )
        );
        $currentUser = $_SESSION['username'];
        $header = 'MIME-Version: 1.0' . "\r\n".
            'Content-type: text/html; charset=iso-8859-1' . "\r\n".
            "From: IT Services <mailrelay@mountbatten.hants.sch.uk>" . "\r\n";

        $userList = array();
        $userList = $this->userHandler->getUsers(); //This is the full list of auth users

        //$template = ($type == 1) ? "resolvedEmail.htm" : "logEmail.htm";

        $f = fopen("err.txt", "a+");
        //check trigger
        //1: New Ticket
        //2: Assigned to Ticket
        //3: Updated Ticket
        //4: Closed Ticket
        switch ($this->getTrigger())
        {
            case 1:
                {
                    $authLogger = "";
                    foreach ($userList as $user)
                    {
                        $authLogger =($_SESSION['username'] == $user->getUsername()) ? $user->getUsername() : "";

                        if ($this->getServiceDesk() == $user->getServiceDesk())
                            mail($user->getEmail(), $this->renderSubject($templates, "LOGGED"), $this->pullTemplate($templates, "LOGGED"), $header);
                    }

                    if(sizeof($authLogger) == 0)
                        mail($_SESSION['username'] . "@mountbatten.hants.sch.uk", $this->renderSubject($templates, "LOGGED"), $this->pullTemplate($templates, "LOGGED"), $header);

                //goes to auth users
                //creator
                }
                break;

            case 2:
            {
                mail($this->getLoggedBy()."@mountbatten.hants.sch.uk", $this->renderSubject($templates, "ASSIGNED"), $this->pullTemplate($templates, "ASSIGNED"), $header);
                if($this->userHandler->getUser($this->getAssignedTo()) != $this->getLoggedBy())
                    mail($this->userHandler->getUser($this->getAssignedTo())."@mountbatten.hants.sch.uk", $this->renderSubject($templates, "ASSIGNED"), $this->pullTemplate($templates, "ASSIGNED"), $header);

                fwrite($f, $this->getLoggedBy() . " " . $this->getAssignedTo());
                fclose($f);
            }
                //goes to assigned user
                //creator
                break;

            case 3:
            {
                $authLogger = "";

                if(sizeof($this->getAssignedTo()) > 0)
                    mail($this->userHandler->getUser($this->getAssignedTo())."@mountbatten.hants.sch.uk", $this->renderSubject($templates, "UPDATED"), $this->pullTemplate($templates, "UPDATED"), $header);
                else
                {

                    foreach ($userList as $user)
                    {
                        $authLogger =($this->getLoggedBy() == $user->getUsername()) ? $user->getUsername() : "";

                        if ($this->getServiceDesk() == $user->getServiceDesk())
                            mail($user->getEmail(), $this->renderSubject($templates, "UPDATED"), $this->pullTemplate($templates, "UPDATED"), $header);
                    }


                }
                if(sizeof($authLogger) == 0)
                    mail($this->getLoggedBy()."@mountbatten.hants.sch.uk", $this->renderSubject($templates, "UPDATED"), $this->pullTemplate($templates, "UPDATED"), $header);

                fwrite($f, $authLogger . " " . $this->getAssignedTo() . " " . $this->getLoggedBy());
                fclose($f);

            }
                //goes to assigned user or auth users
                //creator
                break;

            case 4:
            {
                $closer = ($this->getClosedBy() == $this->getLoggedBy()) ? $this->getLoggedBy() : $this->getClosedBy();
                $assignedTo = ($this->getClosedBy() == $this->userHandler->getUser($this->getAssignedTo())) ? "" : $this->userHandler->getUser($this->getAssignedTo());

                if($closer != $this->getLoggedBy())
                    mail($this->getClosedBy()."@mountbatten.hants.sch.uk", $this->renderSubject($templates, "RESOLVED"), $this->pullTemplate($templates, "RESOLVED"), $header);

                if($assignedTo != $closer)
                    mail($this->userHandler->getUser($this->getAssignedTo())."@mountbatten.hants.sch.uk", $this->renderSubject($templates, "RESOLVED"), $this->pullTemplate($templates, "RESOLVED"), $header);

                mail($this->getLoggedBy()."@mountbatten.hants.sch.uk", $this->renderSubject($templates, "RESOLVED"), $this->pullTemplate($templates, "RESOLVED"), $header);
                fwrite($f, $this->getLoggedBy() ." ". $closer ." " . $assignedTo . "\r\n");
                fclose($f);
            }
                //goes to closing user
                //creator
                break;
        }

        //$email = "itservices@mountbatten.hants.sch.uk"; //replace with authorised users email addresses
        //$to="{$email}";
        //$subject="Helpdesk call {$this->getId()} {$type} by {$this->getLoggedBy()}";
        $message="";

        //mail("adam.wright@mountbatten.hants.sch.uk",$templates[$state]["SUBJECTLINE"],$content, $header);
    }
}