<?php
/**
 * Created by PhpStorm.
 * User: lc4t
 * Date: 10/25/15
 * Time: 4:50 PM
 */
    $_SESSION = array();
    if (@isset($_COOKIE[session_name()]))
    {
        setcookie(session_name(), '', time()-42000, '/');
    }
    @session_destroy();


?>