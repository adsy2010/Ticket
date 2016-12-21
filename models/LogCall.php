<?php
/**
 * Created by PhpStorm.
 * User: awt
 * Date: 26/10/2016
 * Time: 12:41
 */

$ticketHandler = new TicketHandler();

$postedVars = array('loggedBy','location','status');

foreach($postedVars as $x)
    $$x = $_POST[$x];

$ticket = new Ticket(time(), $loggedBy, $location, $status, $assignedTo = null, $id = null);

$ticket->save();

$ticketHandler->addTicket($ticket);