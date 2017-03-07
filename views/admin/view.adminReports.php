<?php
/**
 * Created by PhpStorm.
 * User: awt
 * Date: 25/01/2017
 * Time: 08:53
 */

namespace view;

use controller\TicketHandler;
use controller\UserHandler;
use controllers\PrinterHandler;
use models\Definitions;
use models\Templates;
use models\User;

class adminReports extends Templates implements viewTypes
{

    /**
     * @var PrinterHandler $printerHandler
     */
    private $printerHandler;

    private $userHandler;

    private $ticketHandler;

    private $desk;


    public function __construct($desk)
    {
        parent::__construct();
        $this->setFileName("admin/reports.htm");
        $this->printerHandler = new PrinterHandler();
        $this->ticketHandler = new TicketHandler(2);
        $this->userHandler = new UserHandler();
        $this->setDesk($desk);
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

    private function renderUserRows()
    {
        $row = "<tr><td>{USER}</td><td>{NUMOPEN}</td><td>{NUMCLOSED}</td></tr>";

        $open = array();
        $closed = array();

        foreach ($this->ticketHandler->getTickets() as $ticket)
        {
            if(!isset($open[$this->userHandler->getUser($ticket->getAssignedTo())]))
                $open[$this->userHandler->getUser($ticket->getAssignedTo())] = 0;
            if(!isset($closed[$this->userHandler->getUser($ticket->getAssignedTo())]))
                $closed[$this->userHandler->getUser($ticket->getAssignedTo())] = 0;

            if($ticket->getStatus() == 0 && $ticket->getServiceDesk() == $this->getDesk())
                $open[$this->userHandler->getUser($ticket->getAssignedTo())]++;// = $open[$this->userHandler->getUser($ticket->getAssignedTo())]++;

            if($ticket->getStatus() == 1 && $ticket->getServiceDesk() == $this->getDesk())
                $closed[$this->userHandler->getUser($ticket->getAssignedTo())]++;// = $closed[$this->userHandler->getUser($ticket->getAssignedTo())]++;
        }

        $rows = array();

        foreach ($this->userHandler->getUsers() as $user)
        {
            if(!($open[$user->getUsername()] == 0 && $closed[$user->getUsername()] == 0))
                if($user->getServiceDesk() == $this->getDesk())
                    $rows[] = Definitions::render($row, array(
                        "USER" => $user->getUsername(),
                        "NUMOPEN" => $open[$user->getUsername()],
                        "NUMCLOSED" => $closed[$user->getUsername()]
                    ));
        }
        $rows[] = Definitions::render($row, array(
            "USER" => "Total:",
            "NUMOPEN" => array_sum($open),
            "NUMCLOSED" => array_sum($closed)
            ));

        return implode("\r\n", $rows);

    }

    public function display()
    {
        // TODO: Implement display() method.
        return Definitions::render($this->getLocation().$this->getFileName(),
            array(
                "USERCALLS" => $this->renderUserRows(),
                "PRINTERCOUNT" => $this->printerHandler->getPrinterCount(),
                "CARTRIDGECOUNT" => $this->printerHandler->getCartridgeCount(),
                "SITUATEDPRINTERCOUNT" => $this->printerHandler->getSituatedPrinterCount(),
                "TICKETCOUNTALL" => $this->ticketHandler->getTicketCount(2),
                "TICKETCOUNTCLOSED" => $this->ticketHandler->getTicketCount(1),
                "TICKETCOUNTOPEN"   => $this->ticketHandler->getTicketCount()
        ));
    }

}