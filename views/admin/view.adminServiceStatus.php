<?php
/**
 * Created by PhpStorm.
 * User: awt
 * Date: 25/01/2017
 * Time: 08:52
 */

namespace view;

use controller\TicketHandler;
use models\Definitions;
use models\ServiceDesk;
use models\serviceStatus;
use models\Templates;


class adminServiceStatus extends Templates implements viewTypes
{

    private $ticketHandler;

    public function __construct($desk)
    {
        parent::__construct();
        $this->setFileName("admin/status.htm");
        $this->ticketHandler = new TicketHandler("x");
    }

    private function getStatuses()
    {
        return $this->ticketHandler->getStatuses();
    }

    private function renderStatusRows()
    {
        $statusRowTpl = Definitions::render($this->getLocation()."admin/serviceRow.tpl");
        $statusRowList = array();

        foreach ($this->getStatuses() as $status)
        {
            /** @var ServiceStatus $status */
            $statusRowList[] = Definitions::render($statusRowTpl,
                array(
                    "NAME"      => $status->getName(),
                    "S1"        => ($status->getStatus() == 1) ? "SELECTED" : "",
                    "S2"        => ($status->getStatus() == 2) ? "SELECTED" : "",
                    "S3"        => ($status->getStatus() == 3) ? "SELECTED" : ""
                    ));
        }

        return (!empty($statusRowList)) ? implode("\r\n", $statusRowList) : "";
    }

    public function posted()
    {
        if (isset($_POST['method']) && !empty($_POST['method'])) {

            $id = $_POST['statusName'];

            /**
             * @var ServiceStatus $status
             */
            $status = $this->ticketHandler->getServiceStatus($id);

            switch ($_POST['method']) {
                case "UPDATE": {

                    if(isset($_POST['statusName']))
                        $status->setName($_POST['statusName']);

                    if(isset($_POST['statusStatus']))
                        $status->setStatus($_POST['statusStatus']);

                    $this->ticketHandler->updateServiceStatus($status);
                }
                break;
                case "DELETE": {
                    $this->ticketHandler->removeStatus($status);
                }
                break;
            }
        }

    }

    public function display()
    {
        if(isset($_POST)) $this->posted();
        // TODO: Implement display() method.
        return Definitions::render($this->getLocation().$this->getFileName(),
            array(
                "STATUSROWS" => $this->renderStatusRows()
            )
        );
    }

}