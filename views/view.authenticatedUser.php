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
        return json_encode(array(
            array("JWN1","john.wiseman@mountbatten.hants.sch.uk", "John Wiseman"),
            array("AWT", "adam.wright@mountbatten.hants.sch.uk", "Adam Wright"),
            array("ZCY", "zakir.chowdhary@mountbatten.hants.sch.uk", "Zakir Chowdhary"),
            array("TRS", "toby.rogers@mountbatten.hants.sch.uk", "Toby Rogers")
        ));
    }
}