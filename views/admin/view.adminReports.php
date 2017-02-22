<?php
/**
 * Created by PhpStorm.
 * User: awt
 * Date: 25/01/2017
 * Time: 08:53
 */

namespace view;

use controllers\PrinterHandler;
use models\Definitions;
use models\Templates;

class adminReports extends Templates implements viewTypes
{

    /**
     * @var PrinterHandler $printerHandler
     */
    private $printerHandler;

    public function __construct($desk)
    {
        parent::__construct();
        $this->setFileName("admin/reports.htm");
        $this->printerHandler = new PrinterHandler();
    }

    public function display()
    {
        // TODO: Implement display() method.
        return Definitions::render($this->getLocation().$this->getFileName(),
            array(
                "PRINTERCOUNT" => $this->printerHandler->getPrinterCount(),
                "CARTRIDGECOUNT" => $this->printerHandler->getCartridgeCount(),
                "SITUATEDPRINTERCOUNT" => $this->printerHandler->getSituatedPrinterCount()

        ));
    }

}