<?php
/**
 * Created by PhpStorm.
 * User: awt
 * Date: 25/01/2017
 * Time: 08:49
 */

namespace view;


use models\Definitions;
use models\Templates;

class adminPrinters extends Templates implements viewTypes
{
    public function __construct($desk)
    {
        parent::__construct();
        $this->setFileName("admin/printers.htm");
    }

    public function display()
    {
        // TODO: Implement display() method.
        return Definitions::render($this->getLocation().$this->getFileName());
    }
}