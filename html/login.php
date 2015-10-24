<?php
/**
 * Created by PhpStorm.
 * User: lc4t
 * Date: 10/22/15
 * Time: 12:02 AM
 * function login
 */

    if (isset($_POST['username']) && isset($_POST['password']))
    {
        //raw: the raw input from user,
        $raw_username = $_POST['username'];
        $raw_password = $_POST['password'];

    }
    else
    {
        die('input error');
    }