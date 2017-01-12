<?php
/**
 * Created by PhpStorm.
 * User: awt
 * Date: 10/01/2017
 * Time: 14:30
 */


session_start();
require_once 'includes.inc';

use models\Definitions;


$tpl = 'templates/log.php';

$page = Definitions::render($tpl, array(
    "DESKNAME" => "itservices",
    "DESK" => 1,
    "STATUS" => ""
));
echo $page;


/*
print "CONTENT_TYPE: " . $_SERVER['CONTENT_TYPE'] . "<BR />";
$data = file_get_contents('php://input');
print "DATA: <pre>";
var_dump($data);
var_dump($_POST);
var_dump($_SERVER);
print "</pre>";
?>
<form method="post">

    <input type="text" name="name" value="ok" />
    <input type="submit" value="submit" />

</form>*/