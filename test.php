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

//echo "<form method='post' action='".$_SERVER['PHP_SELF']."'><input name='test' type='text'></input><input type='submit'></form>";
//print_r($_POST);
#$arr = get_defined_vars();
#print_r($arr);
#echo file_get_contents('php://input');
//phpinfo();




function Cryption($crypt, $shift)
{

    $alpha = array(
        "a", "b",
        "c", "d",
        "e", "f",
        "g", "h",
        "i", "j",
        "k", "l",
        "m", "n",
        "o", "p",
        "q", "r",
        "s", "t",
        "u", "v",
        "w", "x",
        "y", "z",
        " "
    );

    $encrypted = str_split($crypt);
    $newletters = array();

    foreach ($encrypted as $letter) {
        foreach ($alpha as $key => $val) {
            if ($val == $letter) {
                if (($key + $shift) > sizeof($alpha)-1)
                    $newletter = $alpha[($key + $shift) - sizeof($alpha)];
                else if (($key + $shift) < 0)
                    $newletter = $alpha[sizeof($alpha) + ($key + $shift)];
                else
                    $newletter = $alpha[$key + $shift];
                break;
            }
        }
        $newletters[] = @$newletter;
    }

    $x = implode("", $newletters);
    return $x;
}

$enc = Cryption("mytextstring", 3);
echo $enc . "\r\n<br>";
echo Cryption($enc, -3);