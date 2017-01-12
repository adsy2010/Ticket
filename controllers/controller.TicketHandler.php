<?php

/**
 * Created by PhpStorm.
 * User: awt
 * Date: 14/11/2016
 * Time: 10:04
 */

namespace controller;

use models\Comment;
use models\Definitions;
use models\Ticket;

class TicketHandler
{

    /** @var Ticket[] $tickets */
    private $tickets = array();
    /** @var \databaseClass $dbobj */
    private $dbObj;

    /**
     * TicketHandler constructor.
     * @param bool $live
     */
    public function __construct($live = TRUE)
    {
        $this->dbObj = new \databaseClass();
        $this->loadTickets($live);
        //$this->testAddTickets();
    }

    /**
     * @param $live
     */
    private function loadTickets($live)
    {
        $this->tickets = null;

        //TRUE  : load live tickets into array
        //FALSE : load closed tickets into array
        //NULL  : load all tickets into the array
        switch ($live)
        {
            case FALSE:     $this->tickets = $this->dbObj->runQuery("SELECT * FROM tickets WHERE status=:status", array("status"=>"closed")); break;
            case NULL:      $this->tickets = $this->dbObj->runQuery("SELECT * FROM tickets", null); break;
            case TRUE:
            DEFAULT:        $this->tickets = $this->dbObj->runQuery("SELECT * FROM tickets WHERE status=:status", array("status"=>"open")); break;
        }


        if(is_array($this->tickets) && !empty($this->tickets))
            foreach ($this->tickets as $ticket)
            {
                $ticket = new Ticket($ticket['time'],$ticket['loggedBy'],$ticket['location'],$ticket['status'], $ticket['assignedTo'],$ticket['id']);
            }
    }

    /**
     *
     */
    private function testAddTickets()
    {
        $t = new Ticket("11:22", "AWT","Server Room", 1);
        $t->setId(1);
        $t->setContent("
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut aliquid scire se gaudeant? Bonum incolumis acies: misera caecitas. Quamquam id quidem licebit iis existimare, qui legerint. Duo Reges: constructio interrete. Occultum facinus esse potuerit, gaudebit; Quae duo sunt, unum facit. Igitur ne dolorem quidem. Itaque hic ipse iam pridem est reiectus; </p>
            <p>Tamen a proposito, inquam, aberramus. Philosophi autem in suis lectulis plerumque moriuntur. Quantum Aristoxeni ingenium consumptum videmus in musicis? An vero, inquit, quisquam potest probare, quod perceptfum, quod. Illud dico, ea, quae dicat, praeclare inter se cohaerere. Homines optimi non intellegunt totam rationem everti, si ita res se habeat. Quid censes in Latino fore? At cum de plurimis eadem dicit, tum certe de maximis. Portenta haec esse dicit, neque ea ratione ullo modo posse vivi; De ingenio eius in his disputationibus, non de moribus quaeritur. Virtutibus igitur rectissime mihi videris et ad consuetudinem nostrae orationis vitia posuisse contraria. Hanc ergo intuens debet institutum illud quasi signum absolvere. </p>
            <p>Haec quo modo conveniant, non sane intellego. Quae qui non vident, nihil umquam magnum ac cognitione dignum amaverunt. Eiuro, inquit adridens, iniquum, hac quidem de re; Ita fit cum gravior, tum etiam splendidior oratio. Conferam tecum, quam cuique verso rem subicias; Cave putes quicquam esse verius. Quid autem habent admirationis, cum prope accesseris? Summus dolor plures dies manere non potest? </p>
            <p>Quod ea non occurrentia fingunt, vincunt Aristonem; An haec ab eo non dicuntur? Non quam nostram quidem, inquit Pomponius iocans; In qua si nihil est praeter rationem, sit in una virtute finis bonorum; Quae cum essent dicta, discessimus. Si enim ad populum me vocas, eum. Quid ergo aliud intellegetur nisi uti ne quae pars naturae neglegatur? Qua tu etiam inprudens utebare non numquam. </p>
            <p>Immo alio genere; Quid vero? Tu enim ista lenius, hic Stoicorum more nos vexat. Quippe: habes enim a rhetoribus; Conferam tecum, quam cuique verso rem subicias; Quid turpius quam sapientis vitam ex insipientium sermone pendere? Ait enim se, si uratur, Quam hoc suave! dicturum. Qui non moveatur et offensione turpitudinis et comprobatione honestatis? </p>
        ");
        $t->setContentType(Definitions::CONTENTTYPESIT[3]);
        $t->setAssignedTo("ZCY");
        $this->addTicket($t);

        $t = new Ticket("11:22", "JWN","Server Room", 1);
        $t->setId(2);
        $t->setContent("This is some content.");
        $t->setContentType(Definitions::CONTENTTYPESIT[4]);
        $this->addTicket($t);

        $t = new Ticket("11:22", "ZCY","IT Office", 1);
        $t->setId(3);
        $t->setContent("This is some content.");
        $t->setContentType(Definitions::CONTENTTYPESIT[6]);
        $t->setAssignedTo("AWT");
        $this->addTicket($t);

        $t = new Ticket("11:22", "TRS","IT2", 1);
        $t->setId(4);
        $t->setContent("This is some content.");
        $t->setContentType(Definitions::CONTENTTYPESIT[8]);
        $this->addTicket($t);
    }

    /*public function addTicket(Ticket $ticket)
    {
        $this->tickets[] = $ticket;
    }*/

    /**
     * New ticket added to the database
     * @param $loggedBy
     * @param $status
     * @param $location
     * @param $content
     * @param $contentType
     * @param $department
     * @param $serviceDesk
     */
    public function addTicket($loggedBy, $status, $location, $content, $contentType, $department, $serviceDesk)
    {
        $ticket = new Ticket();
        $ticket->setLoggedBy($loggedBy);
        $ticket->setStatus($status);
        $ticket->setLocation($location);
        $ticket->setContent($content);
        $ticket->setContentType($contentType);
        $ticket->setDepartment($department);
        $ticket->setServiceDesk($serviceDesk);
        $ticket->add();
    }

    /**
     * @param $ticketId
     * @param $closedBy
     * @param $closedReason
     */
    public function closeTicket($ticketId, $closedBy, $closedReason)
    {
        foreach ($this->getTickets() as $ticket)
        {
            if($ticket->getId() == $ticketId)
            {
                $ticket->setStatus(1);
                $ticket->setClosedBy($closedBy);
                $ticket->setClosedReason($closedReason);
                $ticket->setClosedTime(date("Y-m-d H:i:s", time()));
                $ticket->remove();
                break;
            }
        }
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
        foreach ($this->tickets as $ticket)
        {
            if($ticket->getId() == $ticketId)
            {
                (!empty($status)) ? $ticket->setStatus($status): null;
                (!empty($assignedto)) ? $ticket->setAssignedTo($assignedto): null;
                (!empty($serviceDesk)) ? $ticket->setServiceDesk($serviceDesk): null;
                (!empty($closedTime)) ? $ticket->setClosedTime($closedTime): null;
                (!empty($closedReason)) ? $ticket->setClosedReason($closedReason): null;
                (!empty($closedBy)) ? $ticket->setClosedBy($closedBy): null;
                $ticket->save();
                break;
            }
        }
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
     * @return Ticket
     */
    public function getTicket($id)
    {
        return $this->tickets[$id];
    }

    /**
     * @param int $ticketId A positive integer containing the desired ticketId to search for within the tickets array
     * @return Ticket[] Returns an array of tickets associated with the input ticketId
     */
    public function getTicketByNumber($ticketId)
    {
        $ticketArr = array();
        foreach ($this->getTickets() as $ticket)
        {
            if($ticket->getId() == $ticketId) $ticketArr[] = $ticket;
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
        foreach ($this->getTickets() as $ticket)
        {
            if($ticket->getLoggedBy() == $username) $ticketArr[] = $ticket;
        }

        return $ticketArr;
    }

}