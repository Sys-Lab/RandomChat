<?php
/**
 * Created by PhpStorm.
 * User: lc4t
 * Date: 10/25/15
 * Time: 11:53 PM
 */

require_once ('../include/session_start.php');
require_once ('../include/DB.php');

if (@isset($_GET['user']))
{
    $raw_user = $_GET['user'];
}

// verify login user
if (@isset($_SESSION['username']) && $_SESSION['username'] !== null)
{
    $loginUser = $_SESSION['username'];
    echo 'Login at ' . $loginUser . '<br \>';

    echo '<a href=logout.php>logout</a>' . '<br \>';

    echo '<a href=chat.php>RandomChat Start</a> <br \>';



}
else
{
    echo 'Your have not login.';
}



echo '<br \>' . 'This is the end of home page.';