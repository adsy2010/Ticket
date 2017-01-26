<?php
/**
 * Created by PhpStorm.
 * User: awt
 * Date: 17/11/2016
 * Time: 14:14
 */
/*
$content = file_get_contents("templates/logEmail.htm");
$header = 'MIME-Version: 1.0' . "\r\n";
$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$header .= "From: Adam Wright <mailrelay@mountbatten.hants.sch.uk>" . "\r\n";

mail("adam.wright@mountbatten.hants.sch.uk","Test Email",$content, $header);
echo "Emailed";*/

echo "<form method='post' action='".$_SERVER['PHP_SELF']."'><input name='test' type='text'></input><input type='submit'></form>";
print_r($_POST);
#$arr = get_defined_vars();
#print_r($arr);
#echo file_get_contents('php://input');
phpinfo();