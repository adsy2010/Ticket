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
use models\Templates;

class adminAddCategories extends Templates implements viewTypes
{
    private $ticketHandler;
    private $desk;

    public function __construct($desk)
    {
        parent::__construct();
        $this->setDesk($desk);
        $this->setFileName("admin/addCategory.htm");
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
            $categoryName = $_POST['categoryName'];
            $openState = $_POST['openState'];
            $desk = $_POST['desk'];

            $vars = array(
                "categoryName",
                "openState"
            );

            foreach($vars as $var)
                if(empty($$var))
                    throw new Exception("Some submitted data is missing. The value <strong>{$var}</strong> has been flagged.");


            $newCategory = new Category();
            $newCategory->setName($categoryName);
            $newCategory->setStatusType($openState);
            $newCategory->setDesk($desk);

            $this->ticketHandler->addCategory($newCategory);
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