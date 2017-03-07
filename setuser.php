<?php
/**
 * Created by PhpStorm.
 * User: awt
 * Date: 06/03/2017
 * Time: 13:45
 */


session_start();

if(isset($_POST['username']))
    $_SESSION['username'] = $_POST['username'];

if(isset($_SESSION['username']))
    header("Location: index.php?desk=1");



echo "
<form method='post'>
    Username <input type='text' name='username' id='username'/>
    <input type='submit' value='submit'>
</form>
";

