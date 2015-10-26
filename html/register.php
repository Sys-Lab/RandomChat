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
    $raw_password = $_POST['password'];
    $raw_sex      = $_POST['sex'];
    $raw_email    = $_POST['email'];


    // connect to DB
    $db = new DB();
    $response = $db->addUser($raw_username, $raw_password, $raw_sex, $raw_email, date('Y-m-d H:i:s', time()));
//    print_r($response);
//    print ($response['status']);
    if ($response['status'] === true)
    {// success
        //login(this user)
        $_SESSION['username'] = $response['message']['username'];
        header("Location: home.php?user=" . $response['message']['username']);
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
