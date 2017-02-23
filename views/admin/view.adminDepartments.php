<?php
/**
 * Created by PhpStorm.
 * User: awt
 * Date: 22/02/2017
 * Time: 13:51
 */

namespace view;

use controller\TicketHandler;
use models\Definitions;
use models\Department;
use models\Templates;

class adminDepartments extends Templates implements viewTypes
{
    private $ticketHandler;

    private $desk;

    public function __construct($desk)
    {
        parent::__construct();
        $this->setFileName("admin/departments.htm");
        $this->desk = $desk;
        $this->ticketHandler = new TicketHandler("x");
    }

    /**
     * @return mixed
     */
    public function getDesk()
    {
        return $this->desk;
    }

    private function getDepartments()
    {
        return $this->ticketHandler->getDepartments();
    }

    private function renderDeptRows()
    {
        $deptRowTpl = Definitions::render($this->getLocation()."admin/deptRow.tpl");
        $deptRowList = array();

        foreach ($this->getDepartments() as $dept)
        {
            /** @var Department $dept */
            $deptRowList[] = Definitions::render($deptRowTpl,
                array(
                    "ID"            => $dept->getId(),
                    "DEPARTMENT"    => $dept->getDepartment()
                ));

        }

        return (!empty($deptRowList)) ? implode("\r\n", $deptRowList) : "";
    }

    public function display()
    {
        // TODO: Implement display() method.
        return Definitions::render($this->getLocation().$this->getFileName(),
            array(
                "DESK" => $this->getDesk(),
                "DEPARTMENTROWS" => $this->renderDeptRows()
            ));
    }


}