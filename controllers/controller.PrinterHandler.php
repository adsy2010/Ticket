<?php
/**
 * Created by PhpStorm.
 * User: awt
 * Date: 15/12/2016
 * Time: 13:13
 */

namespace controllers;


use databaseClass;
use models\Cartridge;
use models\CartridgeLog;
use models\Printer;
use Exception;

class PrinterHandler
{

    /** @var Printer[] $printers  */
    private $printers = array();

    /** @var Cartridge[] $cartridges */
    private $cartridges = array();

    private $dbObj;

    public function __construct()
    {
        $this->dbObj = new databaseClass();
        $this->fillData();
    }

    private function fillData()
    {
        $this->loadPrinters();
        $this->loadCartridges();
    }

    private function loadPrinters()
    {
        $sql = "SELECT * FROM printer";
        $data = $this->dbObj->runQuery($sql);

        foreach ($data as $d)
        {
            $printer = new Printer();
            $printer->setId($d['id']);
            $printer->setMake($d['make']);
            $printer->setModel($d['model']);
            $this->printers[] = $printer;
        }
    }

    private function loadCartridges()
    {
        $sql = "SELECT * FROM cartridge";

        $cartridges = array("name", "cost", "stock", "color", "printerID");
        foreach ($cartridges as $c)
        {
            $cartridge = new Cartridge();
            $cartridge->setName($c['name']);
            $cartridge->setCost($c['cost']);
            $cartridge->setStock($c['stock']);
            $cartridge->setColor($c['color']);
            $cartridge->setPrinterID($c['printerID']);
            $this->cartridges[] = $cartridge;
        }
    }

    public function logCartridge($cartridgeId, $userId)
    {
        $cost = 0;
        $cartridgeLog = new CartridgeLog();
        $cartridgeLog->setArchived(false);
        $cartridgeLog->setActionedOn(date("Y-m-d H:i:s", time()));
        $cartridgeLog->setCartridgeId($cartridgeId);
        $cartridgeLog->setUserId($userId);
        foreach ($this->cartridges as $c)
        {
            if($c->getId() == $cartridgeId) {
                $cost = $c->getCost();
                break;
            }
        }
        $cartridgeLog->setCost($cost);
        $cartridgeLog->save();
    }

    public function addPrinter($make, $model, $location)
    {
        $printer = new Printer();
        $printer->setMake($make);
        $printer->setModel($model);
        $printer->setLocation($location);
        $printer->add();
    }

    public function addCartridge($name, $cost, $stock, $color, $printerID)
    {
        $cartridge = new Cartridge();
        $cartridge->setName($name);
        $cartridge->setCost($cost);
        $cartridge->setStock($stock);
        $cartridge->setColor($color);
        $cartridge->setPrinterID($printerID);
        $cartridge->add();
    }

    public function changeCartridgeCost($id, $cost)
    {
        foreach($this->cartridges as $c)
        {
            if($c->getId() == $id) {
                $c->setCost($cost);
                $c->save();
                break;
            }

        }
    }

    public function changeCartridgeStock($id, $amount)
    {
        foreach($this->cartridges as $c)
        {
            if($c->getId() == $id) {

                if(($c->getStock() - $amount) < 0)
                    throw new Exception("Not enough stock.");
                else
                    $c->setStock($c->getStock() - $amount);

                $c->save();
                break;
            }

        }
    }

    public function changePrinterLocation($id, $location)
    {
        foreach($this->printers as $p)
        {
            if($p->getId() == $id) {
                $p->setLocation($location);
                $p->save();
                break;
            }

        }
    }

    public function removePrinter(Printer $printer)
    {
        $printer->remove();
    }

    public function removeCartridge(Cartridge $cartridge)
    {
        $cartridge->remove();
    }

    public function getCartridges()
    {
        return $this->cartridges;
    }

    public function getPrinters()
    {
        return $this->printers;
    }

    public function getPrinter($id)
    {
        foreach($this->getPrinters() as $printer)
        {
            /** @var Printer $printer */
            if($printer->getId() == $id)
                return $printer;
        }
        return false;
    }

}