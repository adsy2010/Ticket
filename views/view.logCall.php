<?php

/**
 * Created by PhpStorm.
 * User: awt
 * Date: 14/11/2016
 * Time: 10:05
 */

namespace view;
use controller\TicketHandler as ticketHandler;
use models\Definitions;

class logCall extends \models\Templates implements viewTypes
{
    private $ticketHandler;

    public function __construct($desk)
    {
        parent::__construct();

        $this->setFileName("log.html");
        $this->ticketHandler = new ticketHandler();
    }

    public function display()
    {
        return Definitions::render($this->getLocation().$this->getFileName());
    }


}