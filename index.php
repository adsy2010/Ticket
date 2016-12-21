<?php
/**
 * Created by PhpStorm.
 * User: awt
 * Date: 14/11/2016
 * Time: 10:03
 */
session_start();
require_once 'includes.inc';

$tpl = 'templates/menu.html';

echo file_get_contents($tpl);