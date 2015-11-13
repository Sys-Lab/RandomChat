<?php
/**
 * Created by PhpStorm.
 * User: lc4t
 * Date: 10/24/15
 * Time: 1:23 AM
 */
require_once ('../include/session_start.php');
require_once ('../include/DB.php');
if (@isset($_POST['username']) && isset($_POST['password']) && isset($_POST['sex']) && isset($_POST['email']))
{
//    raw: the raw input from user,
    $raw_username = $_POST['username'];
    if (! @preg_match("/^[_a-zA-Z0-9]{3,15}$/",$raw_username))
    {
        echo $errorResponse = json_encode
        (
            array
            (   // lack input
                "status" => false,
                "message" => array
                (
                    "errorCode" => -100,  // some thing to change with front
                    "errorMessage" => "username error.",
                ),
            )
        );
        exit (0);
    }
    $raw_password = $_POST['password'];
    if (! @preg_match("/^[_a-zA-Z0-9]{6,16}$/",$raw_password))
    {
        echo $errorResponse = json_encode
        (
            array
            (   // lack input
                "status" => false,
                "message" => array
                (
                    "errorCode" => -102,  // some thing to change with front
                    "errorMessage" => "password error.",
                ),
            )
        );
        exit (0);
    }
    $raw_sex      = $_POST['sex'];
    $raw_email    = $_POST['email'];
// TODO: verify userinput

    // connect to DB
    $db = new DB();
    $response = $db->addUser($raw_username, $raw_password, $raw_sex, $raw_email, date('Y-m-d H:i:s', time()));

    if ($response['status'] === true)
    {//success
        //login(this user)
        echo $response; // to ajax
        $_SESSION['username'] = $response['message']['username'];
        header("Location: home.php");
        exit(0);
    }
    else
    {
        echo json_encode($response);
    }

}
else
{
    echo $errorResponse = json_encode
    (
        array
        (   // lack input
            "status" => false,
            "message" => array
            (
                "errorCode" => -2,  // some thing to change with front
                "errorMessage" => "input error.",
            ),
        )
    );
}
