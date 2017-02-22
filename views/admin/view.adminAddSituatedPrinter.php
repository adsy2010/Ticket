<?php
/**
 * Created by PhpStorm.
 * User: awt
 * Date: 25/01/2017
 * Time: 14:55
 */

namespace view;

use controller\UserHandler;
use controllers\PrinterHandler;
use Exception;
use models\Definitions;
use models\SituatedPrinter;
use models\Templates;
use models\User;

class adminAddSituatedPrinter extends Templates implements viewTypes
{
    private $desk;
    private $printerHandler;

    public function __construct($desk)
    {
        parent::__construct();
        $this->setDesk($desk);
        $this->setFileName("admin/addSituatedPrinter.htm");
        $this->printerHandler = new PrinterHandler();
    }

    /**
     * @param mixed $desk
     */
    private function setDesk($desk)
    {
        $this->desk = $desk;
    }

    private function posted()
    {
        $finalState = "Successfully added to the database";
        try
        {
            $situatedPrinter = $_POST['situatedPrinter']; //ID
            $situatedPrinterLocation = $_POST['situatedPrinterLocation'];
            $situatedPrinterCostDept = $_POST['situatedPrinterCostDept'];
            //$situatedPrinterExemption = $_POST['situatedPrinterExemption'];

            $vars = array(
                "situatedPrinter",
                "situatedPrinterLocation",
                "situatedPrinterCostDept"

            );

            foreach($vars as $var)
                if(empty($$var))
                    throw new Exception("Some submitted data is missing. The value <strong>{$var}</strong> has been flagged.");

            $situatedP = new SituatedPrinter();
            $situatedP->setPrinterId($situatedPrinter);
            $situatedP->setLocation($situatedPrinterLocation);
            $situatedP->setCostDepartment($situatedPrinterCostDept);
            //$situatedP->setExemption($situatedPrinterExemption);

            $this->printerHandler->addSituatedPrinter($situatedP);

        }
        catch (Exception $e)
        {
            $finalState = $e->getMessage();
        }
        return $finalState;
    }

    /**
     * @return mixed
     */
    private function getDesk()
    {
        return $this->desk;
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