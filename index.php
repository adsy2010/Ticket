<?php
/**
 * Created by PhpStorm.
 * User: awt
 * Date: 14/11/2016
 * Time: 10:03
 */
session_start();
error_reporting(E_ALL);
date_default_timezone_set("Europe/London");
require_once 'includes.inc';

//set session username here.
if(!isset($_SESSION['username']))
    header("Location: setuser.php");

const ACTIVESERVICEDESKS = 2;

$desk = (!isset($_GET['desk']) && $_GET['desk'] < (ACTIVESERVICEDESKS - 1)) ? die("No service desk selected") : $_GET['desk'];
echo str_replace("{DESK}", $_GET['desk'], file_get_contents('test.html'));