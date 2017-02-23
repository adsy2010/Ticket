<?php
/**
 * Created by PhpStorm.
 * User: awt
 * Date: 24/01/2017
 * Time: 13:10
 */

namespace view;
use controller\UserHandler;
use controllers\PrinterHandler;
use models\Definitions;
use models\SituatedPrinter;
use models\Templates;
use models\User;

class adminSituatedPrinter extends Templates implements viewTypes
{
    private $printerHandler;
    /**
     * @var
     */
    private $desk;

    public function __construct($desk)
    {
        parent::__construct();
        $this->setFileName("admin/situatedPrinters.htm");
        $this->printerHandler = new PrinterHandler();
        $this->setDesk($desk);
    }


    /**
     * @return mixed
     */
    private function getDesk()
    {
        return $this->desk;
    }

    /**
     * @param mixed $desk
     */
    private function setDesk($desk)
    {
        $this->desk = $desk;
    }

    private function getSituatedPrinters()
    {
        return $this->printerHandler->getSituatedPrinters();
    }

    private function renderSituatedPrinters()
    {
        $situatedPrintersRowTpl = Definitions::render($this->getLocation()."admin/situatedRow.tpl");
        $situatedRowList = array();

        foreach ($this->getSituatedPrinters() as $situatedPrinter)
        {
            /** @var SituatedPrinter $cartridge */
            $situatedRowList[] = Definitions::render($situatedPrintersRowTpl,
                array(
                    "ID"            => $situatedPrinter->getId(),
                    "MAKE"          => $situatedPrinter->getMake(),
                    "MODEL"         => $situatedPrinter->getModel(),
                    "LOCATION"      => $situatedPrinter->getLocation(),
                    "COSTDEPT"      => $this->printerHandler->renderDepartmentSelectList($situatedPrinter->getCostDepartment()),
                    "EXEMPT"        => $situatedPrinter->getExemption()
                ));
        }

        return (!empty($situatedRowList)) ? implode("\r\n", $situatedRowList) : "";
    }

    public function display()
    {
        $template = Definitions::render($this->getLocation().$this->getFileName(),
            array(
                "DESK" => $this->getDesk(),
                "PRINTERROWS" => $this->renderSituatedPrinters()
                ));

        return $template;
    }
}