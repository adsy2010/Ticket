<?php
/**
 * Created by PhpStorm.
 * User: awt
 * Date: 06/03/2017
 * Time: 13:45
 */


session_start();

//if(!isset($_SESSION['staff_username']))
//    header('location: https://mountbatten.hants.sch.uk/adfs/index.php?request=tools/servicedesk');


if(isset($_POST['username']))
    $_SESSION['staff_username'] = strtoupper($_POST['username']);

if(isset($_SESSION['staff_username']))
    header("Location: index.php?desk={$_GET['desk']}");

?>

<form method='post'>
    Username <input type='text' name='username' id='username'/>
    <input type='submit' value='submit'>
</form>


