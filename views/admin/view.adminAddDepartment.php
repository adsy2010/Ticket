<?php
/**
 * Created by PhpStorm.
 * User: awt
 * Date: 30/01/2017
 * Time: 11:56
 */

namespace view;


use controller\TicketHandler;
use Exception;
use models\Category;
use models\Definitions;
use models\Department;
use models\Templates;

class adminAddDepartment extends Templates implements viewTypes
{
    private $ticketHandler;
    private $desk;

    public function __construct($desk)
    {
        parent::__construct();
        $this->setDesk($desk);
        $this->setFileName("admin/addDepartment.htm");
        $this->ticketHandler = new TicketHandler("x");
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
            $deptName = $_POST['departmentName'];

            $vars = array(
                "deptName"
            );

            foreach($vars as $var)
                if(empty($$var))
                    throw new Exception("Some submitted data is missing. The value <strong>{$var}</strong> has been flagged.");


            $department = new Department();
            $department->setDepartment($deptName);

            $this->ticketHandler->addDepartment($department);
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