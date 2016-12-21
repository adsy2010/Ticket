<?php
/**
 * Created by PhpStorm.
 * User: awt
 * Date: 15/12/2016
 * Time: 15:02
 */

namespace models;


class CartridgeLog
{
    private $cartridgeId, $userId, $cost, $actionedOn, $archived;

    /**
     * @return mixed
     */
    public function getCartridgeId()
    {
        return $this->cartridgeId;
    }

    /**
     * @param mixed $cartridgeId
     */
    public function setCartridgeId($cartridgeId)
    {
        $this->cartridgeId = $cartridgeId;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return mixed
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * @param mixed $cost
     */
    public function setCost($cost)
    {
        $this->cost = $cost;
    }

    /**
     * @return mixed
     */
    public function getActionedOn()
    {
        return $this->actionedOn;
    }

    /**
     * @param mixed $actionedOn
     */
    public function setActionedOn($actionedOn)
    {
        $this->actionedOn = $actionedOn;
    }

    /**
     * @return mixed
     */
    public function getArchived()
    {
        return $this->archived;
    }

    /**
     * @param mixed $archived
     */
    public function setArchived($archived)
    {
        $this->archived = $archived;
    }

    public function save()
    {

    }

}