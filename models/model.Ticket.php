<?php

/**
 * Created by PhpStorm.
 * User: awt
 * Date: 25/10/2016
 * Time: 12:32
 */

namespace models;

use Exception;

class Ticket implements iModels
{
    private $time, $loggedBy, $assignedTo, $id, $location, $status,
            $contentType, $content, $department, $serviceDesk,
            $closedBy, $closedReason, $closedTime;

    /** @var Comment[] */
    private $comments = array();

    public function __construct()
    {

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
        $this->status = ($status == 1) ? 'open' : 'closed';
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
    }

    public function add()
    {
        if(!empty($this->getId()))
            throw new Exception("Cannot add ticket to database as ticket is already in the database.");
        $sql = "INSERT INTO tickets (`loggedBy`,`content`,`contentType`,`department`,`location`,`status`,`serviceDesk`) VALUES(?,?,?,?,?,?,?)";
        //$this->email(0);
    }

    //archive
    public function remove()
    {
        if($this->getStatus() != 1)
            throw new Exception("Ticket has not been archived and cannot be closed.");
        if(empty($this->getClosedReason()))
            throw new Exception("Please ensure a closure reason is selected.");
        $sql = "UPDATE tickets SET status=?, closedBy=?, closedReason=?, closedTime=? WHERE logId=?";
        $this->email(1); //send closure email
    }

    //allow unarchive etc
    public function save()
    {
        //if the changer is the current user, allow edits to content?
        $sql = "UPDATE tickets SET status=?, assignedTo=?, closedBy=?, closedReason=?, closedTime=? WHERE logId=?";

    }

    /**
     * Sends emails to authorised users and user who logged the call
     *
     * @param int $type Set to 1 if call is resolved
     */
    private function email($type)
    {
        $email = "itservices@mountbatten.hants.sch.uk"; //replace with authorised users email addresses
        $to="{$email}";
        $subject="Helpdesk call logged by {$this->getLoggedBy()}";
        $message="";

        $template = ($type == 1) ? "resolvedEmail.htm" : "logEmail.htm";
        $content = Definitions::render("templates/{$template}",
            array(
                "LOGGEDBY"          => $this->getLoggedBy(),
                "LOGGEDDATETIME"    => $this->getTime(),
                "LOCATION"          => $this->getLocation(),
                "CONTENT"           => $this->getContent(),
                "RESOLUTION"        => $this->getClosedReason(),
                "RESOLVEDBY"        => $this->getClosedBy(),
                "RESOLVEDDATETIME"  => $this->getClosedTime(),
                "ID"                => $this->getId()
            ));

        $header = 'MIME-Version: 1.0' . "\r\n".
                  'Content-type: text/html; charset=iso-8859-1' . "\r\n".
                  "From: Adam Wright <mailrelay@mountbatten.hants.sch.uk>" . "\r\n";

        mail("adam.wright@mountbatten.hants.sch.uk","Test Email",$content, $header);
    }
}