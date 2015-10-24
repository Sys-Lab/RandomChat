<?php
/**
 * Created by PhpStorm.
 * User: lc4t
 * Date: 10/24/15
 * Time: 1:23 AM
 */
require_once ('../include/DB.php');
if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['sex']) && isset($_POST['email']))
{
//    raw: the raw input from user,
    $raw_username = $_POST['username'];
    $raw_password = $_POST['password'];
    $raw_sex      = $_POST['sex'];
    $raw_email    = $_POST['email'];


    // connect to DB
    $db = new DB();
    $db->addUser($raw_username, $raw_password, $raw_sex, $raw_email, date('Y-m-d H:i:s', time()));

}
else
{
    die('input error');
}