<?php
/**
 * Created by PhpStorm.
 * User: awt
 * Date: 20/12/2016
 * Time: 10:56
 */

namespace models;

/**
 * This interface provides the required functions for models where it is possible to
 * Add
 * Remove
 * Update/Change
 *
 * Although not interface related, dbObj must be passed to an object when a
 * change transaction is required such as adding or removing from the database
 *
 * Interface iModels
 * @package models
 */
interface iModels
{

    public function add();
    public function remove();
    public function save();
}