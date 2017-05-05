<?php

/**
 * Created by PhpStorm.
 * User: awt
 * Date: 14/11/2016
 * Time: 10:04
 */

namespace controller;

use databaseClass;

use models\Category;
use models\Comment;
use models\Definitions;
use models\Department;
use models\ServiceStatus;
use models\Ticket;


class TicketHandler
{

    /** @var Ticket[] $tickets */
    private $tickets = array();

    private $categories = array();
    private $departments = array();

    /** @var databaseClass $dbobj */
    private $dbObj;

    /**
     * TicketHandler constructor.
     *
     * Bool:    "False" for closed
     * Bool:    "True" for open
     * Null:    "Null" for all
     * String:  "x" for none
     * @param mixed $live
     */
    public function __construct($live = 0)
    {
        $this->dbObj = new databaseClass();
        $this->loadTickets($live);
        $this->loadDepartments();
        $this->loadCategories();
        //$this->testAddTickets();
    }

    /**
     * @param $live
     */
    private function loadTickets($live)
    {
        $tickets = null;

        //TRUE  : load live tickets into array
        //FALSE : load closed tickets into array
        //NULL  : load all tickets into the array

        switch ($live) {
            case '0':
                //$sql = "SELECT * FROM tickets WHERE status=? 1";
                $tickets = $this->dbObj->runQuery("SELECT * FROM tickets WHERE status=0 ORDER BY priority DESC, assignedTo ASC");
                break;

            case '1':
                //$sql = "SELECT * FROM tickets WHERE status=?";
                $tickets = $this->dbObj->runQuery("SELECT * FROM tickets WHERE status=1 AND closedTime BETWEEN NOW() - INTERVAL 30 DAY AND NOW() ORDER BY closedTime DESC");
                break;

            case '2':
                //$sql = "SELECT * FROM tickets";
                $tickets = $this->dbObj->runQuery("SELECT * FROM tickets ORDER BY priority, ticketDatetime DESC, ticketDatetime DESC");
                break;

            case "x":
                $sql = "None";
                //this ensures that no queries are run. This is for maintenance such as admin functions
                break;

        }

        if (is_array($tickets) && !empty($tickets))
            foreach ($tickets as $t) {
                $ticket = new Ticket();
                $ticket->setId($t['logId']);
                $ticket->setServiceDesk($t['serviceDesk']);
                $ticket->setLoggedBy($t['loggedBy']);
                $ticket->setLocation($t['location']);
                $ticket->setDepartment($t['department']);
                $ticket->setTime($t['ticketDatetime']);
                $ticket->setStatus($t['status']);
                $ticket->setContent($t['content']);
                $ticket->setContentType($t['contentType']);
                $ticket->setAssignedTo($t['assignedTo']);
                $ticket->setClosedBy($t['closedBy']);
                $ticket->setClosedReason($t['closedReason']);
                $ticket->setClosedTime($t['closedTime']);
                $ticket->setClosedWhy($t['closedWhy']);
                $ticket->setPriority($t['priority']);
                $this->tickets[] = $ticket;
            }
    }

    /**
     * @param int $desk The desk ID for the categories
     *
     */
    public function loadCategories()
    {
        $sql = "SELECT * FROM categories WHERE desk = ? ORDER BY `title` ASC, `statusType` ASC";
        $data = $this->dbObj->runQuery($sql, array(
            $_GET['desk']
        ));

        $categories = array();

        if (is_array($data) && !empty($data))
            foreach ($data as $d) {
                $category = new Category();
                $category->setId($d['id']);
                $category->setName($d['title']);
                $category->setDesk($d['desk']);
                $category->setStatusType($d['statusType']);
                $categories[] = $category;
            }
        $this->categories = $categories;
    }

    private function loadDepartments()
    {
        $sql = "SELECT * FROM departments ORDER BY department ASC";
        $data = $this->dbObj->runQuery($sql);

        $depts = array();

        if (is_array($data) && !empty($data))
            foreach ($data as $d) {
                $dept = new Department();
                $dept->setId($d['id']);
                $dept->setDepartment($d['department']);
                $depts[] = $dept;
            }
        $this->departments = $depts;
    }

    /**
     * private function testAddTickets()
     * {
     * $t = new Ticket("11:22", "AWT","Server Room", 1);
     * $t->setId(1);
     * $t->setContent("
     * <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut aliquid scire se gaudeant? Bonum incolumis acies: misera caecitas. Quamquam id quidem licebit iis existimare, qui legerint. Duo Reges: constructio interrete. Occultum facinus esse potuerit, gaudebit; Quae duo sunt, unum facit. Igitur ne dolorem quidem. Itaque hic ipse iam pridem est reiectus; </p>
     * <p>Tamen a proposito, inquam, aberramus. Philosophi autem in suis lectulis plerumque moriuntur. Quantum Aristoxeni ingenium consumptum videmus in musicis? An vero, inquit, quisquam potest probare, quod perceptfum, quod. Illud dico, ea, quae dicat, praeclare inter se cohaerere. Homines optimi non intellegunt totam rationem everti, si ita res se habeat. Quid censes in Latino fore? At cum de plurimis eadem dicit, tum certe de maximis. Portenta haec esse dicit, neque ea ratione ullo modo posse vivi; De ingenio eius in his disputationibus, non de moribus quaeritur. Virtutibus igitur rectissime mihi videris et ad consuetudinem nostrae orationis vitia posuisse contraria. Hanc ergo intuens debet institutum illud quasi signum absolvere. </p>
     * <p>Haec quo modo conveniant, non sane intellego. Quae qui non vident, nihil umquam magnum ac cognitione dignum amaverunt. Eiuro, inquit adridens, iniquum, hac quidem de re; Ita fit cum gravior, tum etiam splendidior oratio. Conferam tecum, quam cuique verso rem subicias; Cave putes quicquam esse verius. Quid autem habent admirationis, cum prope accesseris? Summus dolor plures dies manere non potest? </p>
     * <p>Quod ea non occurrentia fingunt, vincunt Aristonem; An haec ab eo non dicuntur? Non quam nostram quidem, inquit Pomponius iocans; In qua si nihil est praeter rationem, sit in una virtute finis bonorum; Quae cum essent dicta, discessimus. Si enim ad populum me vocas, eum. Quid ergo aliud intellegetur nisi uti ne quae pars naturae neglegatur? Qua tu etiam inprudens utebare non numquam. </p>
     * <p>Immo alio genere; Quid vero? Tu enim ista lenius, hic Stoicorum more nos vexat. Quippe: habes enim a rhetoribus; Conferam tecum, quam cuique verso rem subicias; Quid turpius quam sapientis vitam ex insipientium sermone pendere? Ait enim se, si uratur, Quam hoc suave! dicturum. Qui non moveatur et offensione turpitudinis et comprobatione honestatis? </p>
     * ");
     * $t->setContentType(Definitions::CONTENTTYPESIT[3]);
     * $t->setAssignedTo("ZCY");
     * $this->addTicket($t);
     *
     * $t = new Ticket("11:22", "JWN","Server Room", 1);
     * $t->setId(2);
     * $t->setContent("This is some content.");
     * $t->setContentType(Definitions::CONTENTTYPESIT[4]);
     * $this->addTicket($t);
     *
     * $t = new Ticket("11:22", "ZCY","IT Office", 1);
     * $t->setId(3);
     * $t->setContent("This is some content.");
     * $t->setContentType(Definitions::CONTENTTYPESIT[6]);
     * $t->setAssignedTo("AWT");
     * $this->addTicket($t);
     *
     * $t = new Ticket("11:22", "TRS","IT2", 1);
     * $t->setId(4);
     * $t->setContent("This is some content.");
     * $t->setContentType(Definitions::CONTENTTYPESIT[8]);
     * $this->addTicket($t);
     * }*/

    /*public function addTicket(Ticket $ticket)
    {
        $this->tickets[] = $ticket;
    }*/

    /**
     * New ticket added to the database
     * @param Ticket $ticket
     */
    public function addTicket(Ticket $ticket)
    {
        $ticket->setDbobj($this->dbObj);
        $ticket->add();
    }

    /**
     * @param $ticketId
     * @param $closedBy
     * @param $closedReason
     */
    public function closeTicket($ticketId, $closedBy, $closedReason)
    {
        /*
        foreach ($this->getTickets() as $ticket) {
            if ($ticket->getId() == $ticketId) {
                $ticket->setStatus(1);
                $ticket->setClosedBy($closedBy);
                $ticket->setClosedReason($closedReason);
                $ticket->setClosedTime(date("Y-m-d H:i:s", time()));
                $ticket->remove();
                break;
            }
        }*/
    }

    /**
     * @param $ticketId
     * @param null $status
     * @param null $assignedto
     * @param null $serviceDesk
     * @param null $closedTime
     * @param null $closedReason
     * @param null $closedBy
     */
    public function changeTicket(
        $ticketId,
        $status = null,
        $assignedto = null,
        $serviceDesk = null,
        $closedTime = null,
        $closedReason = null,
        $closedBy = null
    )
    {
        foreach ($this->tickets as $ticket) {
            if ($ticket->getId() == $ticketId) {
                (!empty($status)) ? $ticket->setStatus($status) : null;
                (!empty($assignedto)) ? $ticket->setAssignedTo($assignedto) : null;
                (!empty($serviceDesk)) ? $ticket->setServiceDesk($serviceDesk) : null;
                (!empty($closedTime)) ? $ticket->setClosedTime($closedTime) : null;
                (!empty($closedReason)) ? $ticket->setClosedReason($closedReason) : null;
                (!empty($closedBy)) ? $ticket->setClosedBy($closedBy) : null;
                $ticket->save();
                break;
            }
        }
    }

    public function assignUserToTicket($id, $authUser, $assigner)
    {
        $ticket = $this->getTicket($id);
        $ticket->setAssignedTo($authUser);

    }

    /**
     * @return Ticket[] Returns an array of Ticket objects
     */
    public function getTickets()
    {
        return $this->tickets;
    }

    /**
     * @param $id
     * @return Ticket|bool
     */
    public function getTicket($id)
    {
        foreach ($this->getTickets() as $ticket)
        {
            /** @var Category $category */
            if($ticket->getId() == $id)
            {
                return $ticket;
            }
        }
        return false;
    }

    /**
     * @param int $ticketId A positive integer containing the desired ticketId to search for within the tickets array
     * @return Ticket[] Returns an array of tickets associated with the input ticketId
     */
    public function getTicketByNumber($ticketId)
    {
        $ticketArr = array();
        foreach ($this->getTickets() as $ticket) {
            if ($ticket->getId() == $ticketId) $ticketArr[] = $ticket;
        }

        return $ticketArr;
    }

    /**
     * @param string $username A string containing the desired username to search for within the tickets array
     * @return Ticket[] Returns an array of tickets associated with the input username
     */
    public function getTicketByLoggedBy($username)
    {
        $ticketArr = array();
        foreach ($this->getTickets() as $ticket) {
            if ($ticket->getLoggedBy() == $username) $ticketArr[] = $ticket;
        }

        return $ticketArr;
    }


    public function getTicketCount($status = null)
    {
        $count = 0;
        switch ($status)
        {
            case 1:
                foreach($this->getTickets() as $ticket)
                    if($ticket->getStatus() == $status) $count++;
                break;
            case 2:
                $count = count($this->getTickets());
                break;

            default:
                foreach($this->getTickets() as $ticket)
                    if($ticket->getStatus() == 0) $count++;
        }

        return $count;
    }

    /**
     * @return Category[]
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param $id
     * @return bool|Category
     */
    public function getCategory($id)
    {
        foreach ($this->getCategories() as $category)
        {
            /** @var Category $category */
            if($category->getId() == $id)
            {
                return $category;
            }
        }
        return false;
    }

    /**
     * Returns Department objects from the database
     *
     * @return Department[]
     */
    public function getDepartments()
    {
        return $this->departments;
    }

    public function getDepartment($id)
    {
        foreach ($this->getDepartments() as $department)
        {
            /** @var Category $category */
            if($department->getId() == $id)
            {
                return $department;
            }
        }
        return false;
    }

    //This should not use desk but might in the future
    /**
     * Returns ServiceStatus objects from the database
     *
     * @return ServiceStatus[]
     */
    public function getStatuses()
    {
        $sql = "SELECT * FROM servicestatus ORDER BY 'status' DESC, 'name' ASC";
        $data = $this->dbObj->runQuery($sql);

        $statuses = array();

        if(is_array($data) && !empty($data))
            foreach ($data as $d) {
                $status = new ServiceStatus();
                $status->setName($d['name']);
                $status->setStatus($d['status']);
                $statuses[] = $status;
            }
        return $statuses;
        //TODO: Talk to martyn about the use of status for the site teams service desk
    }

    /**
     * @param $id
     * @return bool|ServiceStatus
     */
    public function getServiceStatus($id)
    {
        foreach ($this->getStatuses() as $status)
        {
            /** @var ServiceStatus $status */
            if($status->getName() == $id)
            {
                return $status;
            }
        }
        return false;
    }


    /**
     * Returns comments for a particular ticket
     *
     * @param int $id The ticket ID associated with the comments
     * @return Comment[] An array of all comments associated with the ticket ID provided
     */
    public function getComments($id)
    {
        $sql = "SELECT * FROM ticketcomments WHERE logId=? ORDER BY commentDateTime DESC";
        $data = $this->dbObj->runQuery($sql, array($id));

        $comments = array();

        if(is_array($data) && !empty($data))
            foreach ($data as $d)
            {
                $comment = new Comment();
                $comment->setId($d['id']);
                $comment->setTicketID($d['logId']);
                $comment->setCommentDateTime($d['commentDateTime']);
                $comment->setUsername($d['username']);
                $comment->setComment($d['comment']);
                $comments[] = $comment;
            }

        return $comments;
    }

    public function getCommentsByUser($userId)
    {
        $sql = "SELECT * FROM ticketcomments WHERE username=?";
    }



    public function addComment(Comment $comment)
    {
        $comment->setDbobj($this->dbObj);
        $comment->add();
    }

    /**
     * Adds a category to the database
     *
     * @param Category $category
     */
    public function addCategory(Category $category)
    {
        $category->setDb($this->dbObj);
        $category->add();
    }

    /**
     * Adds a status to the database
     *
     * @param ServiceStatus $status
     */
    public function addStatus(ServiceStatus $status)
    {
        $status->setDbObj($this->dbObj);
        $status->add();
    }

    /**
     * Adds a department to the database
     *
     * @param Department $department
     */
    public function addDepartment(Department $department)
    {
        $department->setDbObj($this->dbObj);
        $department->add();
    }


    //Remove functions

    /**
     * Removes a category from the database
     *
     * @param Category $category
     */
    public function removeCategory(Category $category)
    {
        $category->setDb($this->dbObj);
        $category->remove();
    }

    /**
     * Removes a status from the database
     *
     * @param ServiceStatus $status
     */
    public function removeStatus(ServiceStatus $status)
    {
        $status->setDbObj($this->dbObj);
        $status->remove();
    }

    /**
     * Removes a department from the database
     *
     * @param Department $department
     */
    public function removeDepartment(Department $department)
    {
        $department->setDbObj($this->dbObj);
        $department->remove();
    }


    //Update functions

    /**
     * Updates a category with new information
     *
     * @param Category $category
     */
    public function updateCategory(Category $category)
    {
        $category->setDb($this->dbObj);
        $category->save();
    }

    public function updateTicket(Ticket $ticket)
    {
        $ticket->setDbObj($this->dbObj);
        $ticket->save();
    }

    public function updateDepartment(Department $department)
    {
        $department->setDbObj($this->dbObj);
        $department->save();
    }

    public function updateServiceStatus(ServiceStatus $status)
    {
        $status->setDbObj($this->dbObj);
        $status->save();
    }
}