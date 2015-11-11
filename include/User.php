<?php

/**
 * Created by PhpStorm.
 * User: lc4t
 * Date: 15-11-11
 * Time: 21:23
 */

require_once ('../include/session_start.php');
class User
{
    function __construct()
    {
        $this->userSessionId = session_id();

        if ($this->userSessionId === NULL)
        {
            //This is a user without sessionID, may be he delete or does not use cookie.
        }
    }

    public function isLogin()
    {
        return @isset($_SESSION['username']);
    }

    public function getUsername()
    {
        if(@isset($_SESSION['username']))
        {
            return $_SESSION['username'];
        }
    }


    function __destruct()
    {
        //
    }
}