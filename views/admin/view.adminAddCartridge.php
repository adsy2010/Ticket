<?php
/**
 * Created by PhpStorm.
 * User: awt
 * Date: 13/02/2017
 * Time: 09:25
 */

namespace view;


use controllers\PrinterHandler;
use Exception;
use models\Cartridge;
use models\Definitions;
use models\Templates;

class adminAddCartridge extends Templates implements viewTypes
{
    private $printerHandler;
    private $desk;

    public function __construct($desk)
    {
        parent::__construct();
        $this->setDesk($desk);
        $this->setFileName("admin/addCartridge.htm");
        $this->printerHandler = new printerHandler();
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
            $cartridgePrinter = $_POST['cartridgePrinter'];
            $cartridgeName = $_POST['cartridgeName'];
            $cartridgeColor = $_POST['cartridgeColor'];
            $cartridgeStock = ($_POST['cartridgeStock'] == 0) ? 0 : $_POST['cartridgeStock'];
            $cartridgeCost = $_POST['cartridgeCost'];

            $vars = array(
                "cartridgePrinter",
                "cartridgeName",
                "cartridgeColor",
                "cartridgeCost"
            );

            foreach($vars as $var)
                if(empty($$var))
                    throw new Exception("Some submitted data is missing. The value <strong>{$var}</strong> has been flagged.");

            $cartridge = new Cartridge();
            $cartridge->setPrinterID($cartridgePrinter);
            $cartridge->setName($cartridgeName);
            $cartridge->setColor($cartridgeColor);
            $cartridge->setStock($cartridgeStock);
            $cartridge->setCost($cartridgeCost);

            $this->printerHandler->addCartridge($cartridge);

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
                "DESK" => $this->getDesk(),
                "PRINTERS" => $this->printerHandler->renderPrinterSelectList()
            )
        );
    }
}