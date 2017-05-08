<?php
/**
 * Created by PhpStorm.
 * User: awt
 * Date: 08/05/2017
 * Time: 16:03
 */

namespace view;


use controllers\PrinterHandler;
use models\Definitions;
use models\Templates;
use Exception;

class adminLogPrinterCartridge extends Templates implements viewTypes
{

    private $desk;
    private $printerHandler;

    /**
     * adminLogPrinterCartridge constructor.
     * @param $desk
     */
    public function __construct($desk)
    {
        parent::__construct();
        $this->setDesk($desk);
        $this->setFileName("admin/addLogReplacement.htm");
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

    private function posted()
    {
        $finalState = "Successfully added to the database";
        try
        {

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
                "DESK" => $this->getDesk()
            )
        );
    }
}