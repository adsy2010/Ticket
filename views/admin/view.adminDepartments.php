<?php
/**
 * Created by PhpStorm.
 * User: awt
 * Date: 22/02/2017
 * Time: 13:51
 */

namespace view;

use models\Definitions;
use models\Templates;

class adminDepartments extends Templates implements viewTypes
{

    public function __construct($desk)
    {
        parent::__construct();
    }

    private function renderCatRows()
    {
        $deptRowTpl = Definitions::render($this->getLocation()."admin/deptRow.tpl");
        $deptRowList = array();

        foreach ($this->getCategories() as $category)
        {
            /** @var Category $category */
            if($category->getDesk() == $this->getDesk())
            {
                $deptRowList[] = Definitions::render($deptRowTpl,
                    array(
                        "ID"            => $category->getId(),
                        "CATEGORY"      => $category->getName(),
                        "OPENSTATE"     => ($category->getStatusType() == 1) ? "Checked" : "",
                        "CLOSESTATE"   => ($category->getStatusType() == 2) ? "Checked" : "",
                    ));
            }
        }

        return (!empty($deptRowList)) ? implode("\r\n", $deptRowList) : "";
    }

    public function display()
    {
        // TODO: Implement display() method.
    }


}