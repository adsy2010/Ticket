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
use models\Definitions;
use models\Department;
use models\Printer;
use Exception;
use models\SituatedPrinter;

class PrinterHandler
{

    /** @var Printer[] $printers  */
    private $printers = array();

    /** @var Cartridge[] $cartridges */
    private $cartridges = array();

    /** @var Department[] $departments */
    private $departments = array();

    /** @var SituatedPrinter[] $situatedPrinters  */
    private $situatedPrinters = array();

    private $dbObj;

    public function __construct()
    {
        $this->dbObj = new databaseClass();
        $this->fillData(); //loads printer database into memory
    }

    /**
     * Loads all data the printer handler might need.
     */
    private function fillData()
    {
        $this->loadPrinters();
        $this->loadCartridges();
        $this->loadSituatedPrinters();
        $this->loadDepartments();
    }

    /**
     * Loads situated printers
     */
    private function loadSituatedPrinters()
    {
        $sql = "SELECT situatedprinter.*, printer.make, printer.model FROM situatedprinter INNER JOIN printer ON situatedprinter.printerId=printer.id";
        $data = $this->dbObj->runQuery($sql);

        foreach ($data as $d)
        {
            $situatedPrinter = new SituatedPrinter();
            $situatedPrinter->setId($d['id']);
            $situatedPrinter->setPrinterId($d['printerId']);
            $situatedPrinter->setMake($d['make']);
            $situatedPrinter->setModel($d['model']);
            $situatedPrinter->setLocation($d['location']);
            $situatedPrinter->setExemption($d['exemption']);
            $situatedPrinter->setCostDepartment($d['costingdepartment']);
            $this->situatedPrinters[] = $situatedPrinter;
        }
    }

    /**
     * Loads printers
     */
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

    /**
     * Loads cartridges
     */
    private function loadCartridges()
    {
        $sql = "SELECT * FROM cartridge";
        $data = $this->dbObj->runQuery($sql);
        //$cartridges = array("name", "cost", "stock", "color", "printerID");
        foreach ($data as $c)
        {
            $cartridge = new Cartridge();
            $cartridge->setId($c['id']);
            $cartridge->setName($c['name']);
            $cartridge->setCost($c['cost']);
            $cartridge->setStock($c['stock']);
            $cartridge->setColor($c['color']);
            $cartridge->setPrinterID($c['printerId']);
            $this->cartridges[] = $cartridge;
        }
    }

    private function loadDepartments()
    {
        $sql = "SELECT * FROM departments ORDER BY department ASC";
        $data = $this->dbObj->runQuery($sql);

        $depts = array();

        if (is_array($data) && !empty($data))
            foreach ($data as $d) {
                $dept = new Department();
                $dept->setId($d['id']);
                $dept->setDepartment($d['department']);
                $depts[] = $dept;
            }
        $this->departments = $depts;
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


    /**
     * Adds a printer to the database
     *
     * @param Printer $printer
     */
    public function addPrinter(Printer $printer)
    {
        $printer->setDbObj($this->dbObj);
        $printer->add();
    }

    /**
     * Adds a Printers Cartridge to the database
     *
     * @param Cartridge $cartridge
     */
    public function addCartridge(Cartridge $cartridge)
    {
        $cartridge->setDbObj($this->dbObj);
        $cartridge->add();
    }

    /**
     * Adds a Situated Printer to the database
     *
     * @param SituatedPrinter $situatedPrinter
     */
    public function addSituatedPrinter(SituatedPrinter $situatedPrinter)
    {
        $situatedPrinter->setDbObj($this->dbObj);
        $situatedPrinter->add();
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

    /**
     * Deletes a Printer from the database
     *
     * @param Printer $printer A Printer object
     */
    public function removePrinter(Printer $printer)
    {
        $printer->remove();
    }

    /**
     * Deletes a Cartridge from the database
     *
     * @param Cartridge $cartridge A Cartridge object
     */
    public function removeCartridge(Cartridge $cartridge)
    {
        $cartridge->remove();
    }

    /**
     * Returns a list of all cartridges as Cartridge objects from the database
     *
     * @return Cartridge[] A list of Cartridge objects
     */
    public function getCartridges()
    {
        return $this->cartridges;
    }

    /**
     * @return SituatedPrinter[]
     */
    public function getSituatedPrinters()
    {
        return $this->situatedPrinters;
    }

    public function getSituatedPrinter($id)
    {
        foreach($this->getSituatedPrinters() as $situatedPrinter)
        {
            /** @var Printer $printer */
            if($situatedPrinter->getId() == $id)
                return $situatedPrinter;
        }
        return false;
    }

    /**
     * Returns a list of all Printer objects
     *
     * @return Printer[] List of all printer objects
     */
    public function getPrinters()
    {
        return $this->printers;
    }

    /**
     * Returns a Printer object determined by the identifier supplied or
     * false if it doesn't exist
     *
     * @param int $id Numerical identifier for a printer
     * @return bool|Printer Returns false if identifier doesn't exist else returns Printer Object
     */
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

    /**
     * Returns a list of printers as HTML <option>, optionally highlighting a selected printer
     *
     * @param null $highlighted the ID of the printer to be selected by default
     * @return string rendered list of printers as options
     */
    public function renderPrinterSelectList($highlighted = null)
    {
        $template = "<option value='{ID}' {HIGHLIGHT}>{MAKE} - {MODEL}</option>";

        //Ignore this entry if it wasn't passed
        if($highlighted == null)
            $template = str_replace("{HIGHLIGHT}", "", $template);

        $printerList = array();

        foreach ($this->getPrinters() as $printer)
            $printerList[] = Definitions::render($template, array(
                "ID" => $printer->getId(),
                "MAKE" => $printer->getMake(),
                "MODEL" => $printer->getModel(),
                "HIGHLIGHT" => ($highlighted == $printer->getId()) ? "SELECTED" : ""
            ));

        return implode("\r\n", $printerList);

    }

    private function getDepartments()
    {
        return $this->departments;
    }

    public function renderDepartmentSelectList($highlighted = null)
    {
        $template = "<option value='{ID}' {HIGHLIGHT}>{DEPARTMENT}</option>";


        //Ignore this entry if it wasn't passed
        if($highlighted == null)
            $template = str_replace("{HIGHLIGHT}", "", $template);

        $departmentList = array();

        foreach ($this->getDepartments() as $department){
            $departmentList[] = Definitions::render($template, array(
                "ID" => $department->getId(),
                "DEPARTMENT" => $department->getDepartment(),
                "HIGHLIGHT" => ($highlighted == $department->getId()) ? "SELECTED" : ""
            ));
        }


        return implode("\r\n", $departmentList);
    }

    //Used for reports

    /**
     * Returns the number of printers tracked by the database
     *
     * @return int Number of printers
     */
    public function getPrinterCount()
    {
        return count($this->printers);
    }

    /**
     * Returns the number of cartridges tracked by the database
     *
     * @return int Number of cartridges
     */
    public function getCartridgeCount()
    {
        return count($this->cartridges);
    }

    /**
     * Returns the number of deployed printers tracked by the database
     *
     * @return int Number of deployed printers
     */
    public function getSituatedPrinterCount()
    {
        return count($this->situatedPrinters);
    }
}