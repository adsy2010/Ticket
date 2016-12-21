<?php

/**
 * Created by PhpStorm.
 * User: awt
 * Date: 09/11/2016
 * Time: 08:28
 */

namespace models;

class ServiceDesk
{

    private $deskID, $deskName;
    private $ticketHandler;
    
    private $closedCategories = array();
    private $loggedCategories = array();

    //log
    //edit
    //close
    //transfer

    public function __construct($id, $name)
    {
        $this->deskID = $id;
        $this->deskName = $name;

        $this->ticketHandler = new TicketHandler();
        $this->loadDefinitions();
    }

    public function loadDefinitions()
    {
        switch ($this->deskID)
        {
            case 0:
            {
                $this->loggedCategories = Definitions::CONTENTTYPESIT;
                $this->closedCategories = Definitions::CLOSEDREASONSIT;
            }
                break;
            case 1:
            {
                $this->loggedCategories = Definitions::CONTENTTYPESSITE;
                $this->closedCategories = Definitions::CLOSEDREASONSSITE;
            }
                break;
        }
    }

    
}