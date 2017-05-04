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

    public function posted()
    {
        if (isset($_POST['method']) && !empty($_POST['method'])) {

            $id = $_POST['id'];

            /**
             * @var SituatedPrinter $printer
             */
            $printer = $this->printerHandler->getSituatedPrinter($id);

            switch ($_POST['method']) {
                case "UPDATE":
                    {

                        if(isset($_POST['situatedLocation']))
                            $printer->setLocation($_POST['situatedLocation']);

                        if(isset($_POST['situatedExemption']))
                            $printer->setExemption(($_POST['situatedExemption'])? "1" : "0");


                        if(isset($_POST['situatedCostDept']))
                            $printer->setCostDepartment($_POST['situatedCostDept']);

                        $f = fopen("err.log", "w+");
                        fwrite($f, $printer->getExemption());
                        fclose($f);

                        $this->printerHandler->updateSituatedPrinter($printer);
                    }
                    break;
                case "DELETE":
                {
                    $this->printerHandler->removeSituatedPrinter($printer);
                }
            }
        }

    }

    public function display()
    {
        if(isset($_POST)) $this->posted();
        $template = Definitions::render($this->getLocation().$this->getFileName(),
            array(
                "DESK" => $this->getDesk(),
                "PRINTERROWS" => $this->renderSituatedPrinters()
                ));

        return $template;
    }
}