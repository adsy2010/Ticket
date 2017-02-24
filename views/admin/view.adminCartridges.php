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

    public function getCartridge($id)
    {
        return $this->printerHandler->getCartridge($id);
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
                    "COST"          => number_format($cartridge->getCost(),2,'.',','),
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

            $id = $_POST['id'];

            switch ($_POST['method'])
            {
                case 'DELETE':
                {
                    $cartridge = new Cartridge();
                    $cartridge->setId($id);
                    $this->printerHandler->removeCartridge($cartridge);
                } break;
                /*case 'SAVE': $cat->save(); break;*/
                case 'UPDATE':
                {
                    $cartridge = $this->getCartridge($id);

                    if(isset($_POST['cartridgeName']) && !empty($_POST['cartridgeName']))
                        $cartridge->setName($_POST['cartridgeName']);

                    if(isset($_POST["cartridgeColor"]) && !empty($_POST["cartridgeColor"]))
                        $cartridge->setColor($_POST["cartridgeColor"]);

                    if(isset($_POST["cartridgeStock"]) && !empty($_POST["cartridgeStock"]))
                        $cartridge->setStock($_POST["cartridgeStock"]);

                    if(isset($_POST["cartridgePrinterName"]) && !empty($_POST["cartridgePrinterName"]))
                        $cartridge->setPrinterID($_POST["cartridgePrinterName"]);

                    if(isset($_POST["cartridgeCost"]) && !empty($_POST["cartridgeCost"]))
                        $cartridge->setCost($_POST["cartridgeCost"]);

                    $this->printerHandler->updateCartridge($cartridge);
                }
            }
        }
    }

    public function display()
    {
        // TODO: Implement display() method.
        if(isset($_POST)) $this->posted();
        return Definitions::render($this->getLocation().$this->getFileName(),
            array(
                "CARTRIDGEROWS" => $this->renderCartridgeRows()
            )
        );
    }
}