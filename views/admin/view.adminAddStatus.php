<?php
/**
 * Created by PhpStorm.
 * User: awt
 * Date: 13/02/2017
 * Time: 09:24
 */

namespace view;


use controller\TicketHandler;
use Exception;
use models\Definitions;
use models\ServiceStatus;
use models\Templates;

class adminAddStatus extends Templates implements viewTypes
{
    private $desk;
    private $ticketHandler;

    public function __construct($desk)
    {
        parent::__construct();
        $this->setDesk($desk);
        $this->setFileName("admin/addStatus.htm");
        $this->ticketHandler = new TicketHandler("x");
    }

    /**
     * @return mixed
     */
    public function getDesk()
    {
        return $this->desk;
    }

    /**
     * @param mixed $desk
     */
    public function setDesk($desk)
    {
        $this->desk = $desk;
    }

    public function posted()
    {
        $finalState = "Successfully added to the database";
        try {
            $statusName = $_POST['statusName'];
            $desk = $_POST['desk'];

            $vars = array(
                "statusName"
            );

            foreach($vars as $var)
                if(empty($$var))
                    throw new Exception("Some submitted data is missing. The value <strong>{$var}</strong> has been flagged.");

            $status = new ServiceStatus();
            $status->setName($statusName);
            $status->setDesk($desk);

            $this->ticketHandler->addStatus($status);

        }
        catch (Exception $e)
        {
            $finalState = $e->getMessage();
        }
        return $finalState;
    }

    public function display()
    {
        // TODO: Implement display() method.
        $state = ""; //set as not submitted
        if(isset($_POST) && !empty($_POST)) $state = $this->posted();

        //print_r($_POST);
        return Definitions::render($this->getLocation().$this->getFileName(),
            array(
                "STATUS" => $state,
                "DESK" => $this->getDesk()
            )
        );
    }
}