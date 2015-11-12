<?php
/**
 * Created by PhpStorm.
 * User: lc4t
 * Date: 10/22/15
 * Time: 12:02 AM
 * function login
 */
require_once ('../include/session_start.php');
require_once ('../include/DB.php');
require_once ('../include/User.php');
$user = new User();
if ($user->isLogin())// had login
{
    header("Location: home.php");
    exit(0);
}


if (@isset($_POST['username']) && isset($_POST['password']))
{

    $raw_username = $_POST['username'];
    $raw_password = $_POST['password'];
    $db = new DB();
    $response = $db -> loginUser($raw_username, $raw_password, date('Y-m-d H:i:s', time()));
    if ($response['status'] === true)
    {
        $_SESSION['username'] = $response['message']['username'];
        header('Location: home.php');
    }
    else
    {
        echo json_encode($response);
    }


}
else
{
    die('input error');
}