<?php
/**
 * Created by PhpStorm.
 * User: awt
 * Date: 20/12/2016
 * Time: 11:07
 */

namespace models;


use databaseClass;

class Comment implements iModels
{
    private $id, $username, $ticketID, $commentDateTime, $comment;

    /**
     * @var databaseClass $dbobj
     */
    private $dbobj;

    /**
     * @return mixed
     */
    private function getDbobj()
    {
        return $this->dbobj;
    }

    /**
     * @param mixed $dbobj
     */
    public function setDbobj($dbobj)
    {
        $this->dbobj = $dbobj;
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
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $userID
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getTicketID()
    {
        return $this->ticketID;
    }

    /**
     * @param mixed $ticketID
     */
    public function setTicketID($ticketID)
    {
        $this->ticketID = $ticketID;
    }

    /**
     * @return mixed
     */
    public function getCommentDateTime()
    {
        return $this->commentDateTime;
    }

    /**
     * @param mixed $commentDateTime
     */
    public function setCommentDateTime($commentDateTime)
    {
        $this->commentDateTime = $commentDateTime;
    }

    /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param mixed $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    public function add()
    {
        $sql = "INSERT INTO ticketcomments (username, logId, comment) VALUES (?,?,?)";
        $this->getDbobj()->runQuery($sql, array(
            $this->getUsername(),
            $this->getTicketID(),
            $this->getComment()
        ));

    }

    public function remove()
    {
        $sql = "DELETE FROM ticketcomments WHERE id=?";
        $this->getDbobj()->runQuery($sql, array(
            $this->getId()
        ));
    }

    public function save()
    {
        $sql = "UPDATE ticketcomments SET comment=? WHERE id=?";
        $this->getDbobj()->runQuery($sql,array(
            $this->getComment(),
            $this->getId()
        ));
    }
}