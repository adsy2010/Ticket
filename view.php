<?php
/**
 * Created by PhpStorm.
 * User: awt
 * Date: 15/11/2016
 * Time: 11:22
 */
if(!session_start()) session_start();
date_default_timezone_set("Europe/London");
require_once 'includes.inc';


if(!isset($_GET['view']) && !isset($_GET['adminPage']))
    die('No view Supplied');

$desk = (!isset($_GET['desk'])) ? 1 : $_GET['desk'];

if($_GET['desk'] >1 || $_GET['desk'] < 0) die("Service Desk does not exist.");

$viewObj = null;

switch (@$_GET['view'])
{
    //logs
    case 'open': $viewObj = new view\openLogs($desk); break;
    case 'closed': $viewObj = new view\closedLogs($desk); break;
    case 'all': $viewObj = new view\allLogs($desk); break;
    case 'my': $viewObj = new view\myLogs($desk); break;

    //window in a window
    case 'logTicket': $viewObj = new view\logCall($desk); break;

    case 'comments': $viewObj           = new view\comments($desk); break;

    //admin
    case 'adminHome': $viewObj = new view\administerHome($desk); break;
    case 'authenticatedUsers': $viewObj = new view\authenticatedUser($desk); break;
}

switch (@$_GET['adminPage'])
{
    case 'dashboard': $viewObj           = new view\adminDashboard($desk); break;
    case 'cartridges': $viewObj          = new view\adminCartridges($desk); break;
    case 'categories': $viewObj          = new view\adminCategories($desk); break;
    case 'departments': $viewObj         = new view\adminDepartments($desk); break;
    case 'printers': $viewObj            = new view\adminPrinters($desk); break;
    case 'situatedprinter': $viewObj     = new view\adminSituatedPrinter($desk); break;
    case 'reports': $viewObj             = new view\adminReports($desk); break;
    case 'servicestatus': $viewObj       = new view\adminServiceStatus($desk); break;

    case 'addUser': $viewObj             = new view\adminAddUser($desk); break;
    case 'addCategory': $viewObj         = new view\adminAddCategories($desk); break;
    case 'addDepartment': $viewObj       = new view\adminAddDepartment($desk); break;
    case 'addPrinter': $viewObj          = new view\adminAddPrinter($desk); break;
    case 'addCartridge': $viewObj        = new view\adminAddCartridge($desk); break;
    case 'addStatus': $viewObj           = new view\adminAddStatus($desk); break;
    case 'addSituatedPrinter': $viewObj  = new view\adminAddSituatedPrinter($desk); break;
    case 'logPrinterCartridge': $viewObj = new view\adminLogPrinterCartridge($desk); break;
}

if($viewObj == null)
    die('View was invalid or missing.');

echo $viewObj->display();