<?php
/**
 * Created by PhpStorm.
 * User: awt
 * Date: 27/01/2017
 * Time: 14:45
 */

namespace view;


use models\Definitions;
use models\Templates;

class adminCategories extends Templates implements viewTypes
{

    public function __construct($desk)
    {
        parent::__construct();
        $this->setFileName("admin/categories.htm");
    }

    public function display()
    {
        // TODO: Implement display() method.
        return Definitions::render($this->getLocation().$this->getFileName(),
            array(
                "CATEGORYROWS" => ""
            ));
    }
}