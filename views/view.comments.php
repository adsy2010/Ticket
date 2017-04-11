<?php
/**
 * Created by PhpStorm.
 * User: awt
 * Date: 15/11/2016
 * Time: 16:10
 */

namespace view;


use controller\TicketHandler;
use models\Comment;
use models\Definitions;
use models\Templates;

class comments extends Templates implements viewTypes
{
    private $ticketHandler;

    private $tpl = "comments.tpl";

    public function __construct($desk)
    {
        parent::__construct();
        $this->ticketHandler = new TicketHandler("x");
    }

    private function posted()
    {
        if(isset($_POST['method']) && !empty($_POST['method'])) {

            $id = $_POST['id'];

            switch ($_POST['method'])
            {
                case "UPDATE":
                {

                }
                break;

                case "DELETE":
                {

                }
                break;

                case "ADD":
                {
                    if(isset($_POST['comment']) && isset($_POST['logID']))
                    {
                        $comment = new Comment();
                        $comment->setComment(htmlspecialchars($_POST['comment']));
                        $comment->setTicketID($_POST['id']);
                        $comment->setUsername($_SESSION['username']);

                        $this->ticketHandler->addComment($comment);
                    }
                }
                break;
            }
        }
    }

    public function display()
    {
        if(isset($_POST)) $this->posted();

        return;// Definitions::render($this->getLocation() . $this->tpl,
            //array(

            //));
    }
}