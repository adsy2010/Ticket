<?php
/**
 * Created by PhpStorm.
 * User: awt
 * Date: 15/11/2016
 * Time: 11:22
 */

require_once 'includes.inc';

if(!isset($_GET['view']))
    die('No view Supplied');

$desk = (!isset($_GET['desk'])) ? "IT" : $_GET['desk'];

$viewObj = null;

switch ($_GET['view'])
{
    //logs
    case 'open': $viewObj = new view\allLogs($desk); break;
    case 'closed': $viewObj = new view\closedLogs($desk); break;
    case 'all': $viewObj = new view\allLogs($desk); break;
    case 'my': $viewObj = new view\myLogs($desk); break;

    case 'logTicket': $viewObj = new view\logCall($desk); break;

    //admin
    case 'adminHome': $viewObj = new view\administerHome($desk); break;
    case 'authenticatedUsers': $viewObj = new view\authenticatedUser($desk); break;
}

if($viewObj == null)
    die('View was invalid or missing.');

echo $viewObj->display();