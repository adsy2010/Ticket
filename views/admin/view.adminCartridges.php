<?php
/**
 * Created by PhpStorm.
 * User: awt
 * Date: 25/01/2017
 * Time: 08:50
 */

namespace view;


use controller\TicketHandler;
use controllers\PrinterHandler;
use models\Cartridge;
use models\Definitions;
use models\Templates;

class adminCartridges extends Templates implements viewTypes
{

    private $desk;
    private $printerHandler;

    public function __construct($desk)
    {
        parent::__construct();
        $this->setFileName("admin/cartridges.htm");
        $this->printerHandler = new PrinterHandler();
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

    private function getCartridges()
    {
        return $this->printerHandler->getCartridges();
    }

    private function renderCartridgeRows()
    {
        $cartridgeRowTpl = Definitions::render($this->getLocation()."admin/cartridgesRow.tpl");
        $cartridgeRowList = array();

        foreach ($this->getCartridges() as $cartridge)
        {
            /** @var Cartridge $cartridge */
            $cartridgeRowList[] = Definitions::render($cartridgeRowTpl,
                array(
                    "ID"            => $cartridge->getId(),
                    "NAME"          => $cartridge->getName(),
                    "STOCK"         => $cartridge->getStock(),
                    "COST"          => $cartridge->getCost(),
                    "BLACK"         => ($cartridge->getColor() == "black") ? "SELECTED" : "",
                    "YELLOW"        => ($cartridge->getColor() == "yellow") ? "SELECTED" : "",
                    "CYAN"          => ($cartridge->getColor() == "cyan") ? "SELECTED" : "",
                    "MAGENTA"       => ($cartridge->getColor() == "magenta") ? "SELECTED" : "",
                    "PRINTERS"      => $this->printerHandler->renderPrinterSelectList($cartridge->getPrinterID())
                ));
        }

        return (!empty($cartridgeRowList)) ? implode("\r\n", $cartridgeRowList) : "";
    }

    private function posted()
    {
        if(isset($_POST['method']) && !empty($_POST['method'])) {
            $cartridge = new Cartridge();
            $cartridge->setId($_POST['id']);

            switch ($_POST['method'])
            {
                case 'DELETE': $this->printerHandler->removeCartridge($cartridge); break;
                /*case 'SAVE': $cat->save(); break;*/
            }
        }
    }

    public function display()
    {
        // TODO: Implement display() method.
        return Definitions::render($this->getLocation().$this->getFileName(),
            array(
                "CARTRIDGEROWS" => $this->renderCartridgeRows()
            )
        );
    }
}