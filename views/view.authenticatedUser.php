<?php
/**
 * Created by PhpStorm.
 * User: awt
 * Date: 15/11/2016
 * Time: 14:22
 */

namespace view;
use controller\UserHandler;


/**
 * Probably an unused class
 *
 * Class authenticatedUser
 * @package view
 */
class authenticatedUser implements viewTypes
{
    private $desk;

    private $userHandler;

    public function __construct($desk)
    {
        $this->userHandler = new UserHandler();
        $this->desk = $desk;
    }

    /**
     * @return bool
     */
    public function display()
    {
        // TODO: Implement display() method.
        return $this->userHandler->isUserOnDesk($_SESSION['staff_username'], $this->desk);
    }
}