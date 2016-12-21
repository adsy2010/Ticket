<?php
/**
 * Created by PhpStorm.
 * User: awt
 * Date: 15/11/2016
 * Time: 14:22
 */

namespace view;


class authenticatedUser implements viewTypes
{

    public function __construct($desk)
    {

    }

    /**
     * @return array Returns an array of all authenticated users
     */
    public function display()
    {
        // TODO: Implement display() method.
        return json_encode(array("JWN1", "AWT", "ZCY", "TRS"));
    }
}