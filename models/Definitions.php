<?php

/**
 * Created by PhpStorm.
 * User: awt
 * Date: 26/10/2016
 * Time: 12:49
 */

namespace models;
use Exception as Exception;

class Definitions
{
    const CONTENTTYPESIT = array(
        "Change Request",
        "Email",
        "iDevice",
        "Interactive Whiteboard",
        "Internet",
        "Laptop",
        "Network",
        "Other",
        "PC",
        "Printer",
        "Projector",
        "Server",
        "SIMS",
        "Software",
        "Website"
    );
    const CONTENTTYPESSITE = array(
        "Request",
        "Issue"
    );

    const CLOSEDREASONSIT = array(
        "Job Complete",
        "System Updated",
        "Hardware Repaired",
        "Hardware Replaced",
        "Data Recovered"
    );

    const CLOSEDREASONSSITE = array(
        "Work Complete",
        "Vandalism",
        "Request Actioned"
    );

    public static function render($template, $data = array())
    {
        if(empty($template))
            throw new Exception("No template supplied");
        if(!is_array($data))
            throw new Exception("Data supplied was not in an array format.\r\nPlease ensure data is sent in the format <b>name</b> => value");

        $tpl = (is_file($template)) ? file_get_contents($template) : $template;

        //print_r($data);
        foreach ($data as $key => $val)
            $tpl = str_replace("{{$key}}", $val, $tpl);


        return $tpl;

    }

}