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

    public function __construct($time, $loggedBy, $location, $status, $assignedTo = null, $id = null)
    {
        $this->setAssignedTo($assignedTo);
        $this->setId($id);
        $this->setLocation($location);
        $this->setLoggedBy($loggedBy);
        $this->setStatus($status);
        $this->setTime($time);
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
     * @param array $status
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
        $sql = "INSERT INTO ticket (`time`,`loggedBy`,`location`,`status`) VALUES(?,?,?,?)";

    }

    //archive
    public function remove()
    {
        if($this->getStatus() != 1)
            throw new Exception("Ticket has not been archived and cannot be closed.");
        if(empty($this->getClosedReason()))
            throw new Exception("Please ensure a closure reason is selected.");
        $sql = "UPDATE ticket SET status=?, closedBy=?, closedReason=?, closedTime=? WHERE id=?";
    }

    //allow unarchive etc
    public function save()
    {
        //if the changer is the current user, allow edits to content?
        $sql = "UPDATE ticket SET status=?, assignedTo=?, closedBy=?, closedReason=?, closedTime=? WHERE id=?";

    }
}