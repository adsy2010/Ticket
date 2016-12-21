<?php
/**
 * Created by PhpStorm.
 * User: awt
 * Date: 20/12/2016
 * Time: 11:07
 */

namespace models;


class Comment implements iModels
{
    private $id, $userID, $ticketID, $commentDateTime, $comment;

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
    public function getUserID()
    {
        return $this->userID;
    }

    /**
     * @param mixed $userID
     */
    public function setUserID($userID)
    {
        $this->userID = $userID;
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
        // TODO: Implement add() method.
    }

    public function remove()
    {
        // TODO: Implement remove() method.
    }

    public function save()
    {
        // TODO: Implement save() method.
    }
}