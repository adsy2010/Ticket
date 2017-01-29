<?php
/**
 * Created by PhpStorm.
 * User: awt
 * Date: 14/11/2016
 * Time: 10:03
 */
session_start();
error_reporting(E_ALL);
require_once 'includes.inc';
$_SESSION['username'] = "AWT";
$tpl = 'templates/menu.html';

echo str_replace("{DESK}", $_GET['desk'], file_get_contents($tpl));