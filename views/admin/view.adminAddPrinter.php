<?php
/**
 * Created by PhpStorm.
 * User: awt
 * Date: 13/02/2017
 * Time: 09:24
 */

namespace view;

use controllers\PrinterHandler;
use Exception;
use models\Definitions;
use models\Printer;
use models\Templates;

class adminAddPrinter extends Templates implements viewTypes
{
    private $printerHandler;
    private $desk;

    public function __construct($desk)
    {
        parent::__construct();
        $this->setDesk($desk);
        $this->setFileName("admin/addPrinter.htm");
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
            $printerMake = $_POST['printerMake'];
            $printerModel = $_POST['printerModel'];

            $vars = array(
                "printerMake",
                "printerModel"
            );

            foreach($vars as $var)
                if(empty($$var))
                    throw new Exception("Some submitted data is missing. The value <strong>{$var}</strong> has been flagged.");

            $printer = new Printer();
            $printer->setMake($printerMake);
            $printer->setModel($printerModel);

            $this->printerHandler->addPrinter($printer);

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
        if (isset($_POST) && !empty($_POST)) $state = $this->posted();

        //print_r($_POST);
        return Definitions::render($this->getLocation() . $this->getFileName(),
            array(
                "STATUS" => $state,
                "DESK" => $this->getDesk()
            )
        );
    }
}