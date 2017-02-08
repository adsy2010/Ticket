<?php
/**
 * Created by PhpStorm.
 * User: awt
 * Date: 27/01/2017
 * Time: 14:45
 */

namespace view;


use controller\TicketHandler;
use models\Category;
use models\Definitions;
use models\Templates;

class adminCategories extends Templates implements viewTypes
{
    private $ticketHandler;
    private $desk;

    public function __construct($desk)
    {
        parent::__construct();
        $this->setDesk($desk);
        $this->setFileName("admin/categories.htm");
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

    private function getCategories()
    {
        return $this->ticketHandler->getCategories($this->getDesk());
    }

    private function renderCatRows()
    {
        $catRowTpl = Definitions::render($this->getLocation()."admin/catRow.tpl");
        $catRowList = array();

        foreach ($this->getCategories() as $category)
        {
            /** @var Category $category */
            if($category->getDesk() == $this->getDesk())
            {
                $catRowList[] = Definitions::render($catRowTpl,
                    array(
                        "ID"            => $category->getId(),
                        "CATEGORY"      => $category->getName(),
                        "OPENSTATE"     => ($category->getStatusType() == 1) ? "Checked" : "",
                        "CLOSESTATE"   => ($category->getStatusType() == 2) ? "Checked" : "",
                    ));
            }
        }

        return (!empty($catRowList)) ? implode("\r\n", $catRowList) : "";
    }

    private function posted()
    {
        if(isset($_POST['method']) && !empty($_POST['method'])) {
            $cat = new Category();
            $cat->setId($_POST['id']);

            switch ($_POST['method'])
            {
                case 'DELETE': $this->ticketHandler->removeCategory($cat); break;
                /*case 'SAVE': $cat->save(); break;*/
            }
        }
    }

    public function display()
    {
        // TODO: Implement display() method.

        if(isset($_POST)) $this->posted();
        return Definitions::render($this->getLocation().$this->getFileName(),
            array(
                "CATEGORYROWS" => $this->renderCatRows(),
                "DESK" => $this->getDesk()
            ));
    }
}