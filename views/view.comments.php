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

    private $tplComments = "comments.tpl";

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
                    if(isset($_POST['id']))
                    {
                        $comment = new Comment();
                        $comment->setTicketID($_POST['id']);
                        //TODO: implement method removeComment in TicketHandler
                        //$this->ticketHandler->removeComment($comment);
                    }
                }
                break;

                case "ADD":
                {
                    if(isset($_POST['info']) && isset($_POST['id']))
                    {
                        $comment = new Comment();
                        $comment->setComment(htmlspecialchars($_POST['info']));
                        $comment->setTicketID($_POST['id']);
                        $comment->setUsername($_SESSION['username']);

                        $this->ticketHandler->addComment($comment);
                    }
                }
                break;
            }
        }
    }

    private function renderCommentRows($id)
    {
        $row = "<div> <div>{COMMENTDATETIME} by <strong>{COMMENTOR}</strong></div> <div>{COMMENT}<hr></div> </div>";

        $rows = array();

        $comments = $this->ticketHandler->getComments($id);
        if (sizeof($comments) == 0) {
            $rows[] = "No comments";

        }
        else
        {
            foreach ($comments as $comment)
            {
                $rows[] = Definitions::render($row, array(
                    "COMMENTDATETIME" => "Comment made at " . date("H:i:s ".'\o\n'." jS M Y", strtotime($comment->getCommentDateTime())),
                    "COMMENTOR" =>  $comment->getUsername(),
                    "COMMENT"   => html_entity_decode($comment->getComment())
                ));
            }
        }


        return implode("\r\n", $rows);
    }

    private function renderComments()
    {
        //return ;
        $id = (isset($_POST['id'])) ? $_POST['id'] : 0;
        return Definitions::render($this->getLocation() . $this->tplComments, array(
            "LOGID" => $id,
            "ROWS" => $this->renderCommentRows($id)
        ));
    }

    public function display()
    {
        if(isset($_POST)) $this->posted();
        return $this->renderComments();

    }
}