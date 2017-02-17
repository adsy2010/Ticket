<?php
/**
 * Created by PhpStorm.
 * User: awt
 * Date: 13/02/2017
 * Time: 09:25
 */

namespace view;


use controllers\PrinterHandler;
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