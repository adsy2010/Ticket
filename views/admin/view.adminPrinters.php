<?php
/**
 * Created by PhpStorm.
 * User: awt
 * Date: 25/01/2017
 * Time: 08:49
 */

namespace view;


use controllers\PrinterHandler;
use models\Definitions;
use models\Printer;
use models\Templates;

class adminPrinters extends Templates implements viewTypes
{
    private $printerHandler;
    private $desk;

    public function __construct($desk)
    {
        parent::__construct();
        $this->setFileName("admin/printers.htm");
        $this->setDesk($desk);
        $this->printerHandler = new PrinterHandler();
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

    private function getPrinters()
    {
        return $this->printerHandler->getPrinters();
    }

    private function renderPrinterRows()
    {
        $printerRowTpl = Definitions::render($this->getLocation()."admin/printersRow.tpl");
        $printerRowList = array();

        foreach ($this->getPrinters() as $printer)
        {
            /** @var Printer $printer */
            $printerRowList[] = Definitions::render($printerRowTpl,
                array(
                    "ID"        => $printer->getId(),
                    "MAKE"      => $printer->getMake(),
                    "MODEL"     => $printer->getModel()
                ));
        }

        return (!empty($printerRowList)) ? implode("\r\n", $printerRowList) : "";
    }

    private function posted()
    {
        if(isset($_POST['method']) && !empty($_POST['method'])) {

            $id = $_POST['id'];

            $printer = $this->printerHandler->getPrinter($id);

            switch ($_POST['method'])
            {
                case 'UPDATE':
                {
                        if(isset($_POST['printerModel']))
                            $printer->setModel($_POST['printerModel']);

                        if(isset($_POST['printerMake']))
                            $printer->setMake($_POST['printerMake']);

                        $this->printerHandler->updatePrinter($printer);
                }
                break;

                case 'DELETE': $this->printerHandler->removePrinter($printer); break;
                /*case 'SAVE': $cat->save(); break;*/
            }
        }
    }

    public function display()
    {
        if(isset($_POST)) $this->posted();

        return Definitions::render($this->getLocation().$this->getFileName(),
            array(
                "PRINTERROWS" => $this->renderPrinterRows()
            )
        );
    }
}