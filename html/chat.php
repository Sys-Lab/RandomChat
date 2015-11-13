<?php
/**
 * Created by PhpStorm.
 * User: lc4t
 * Date: 15-11-11
 * Time: 20:06
 */

require_once ('../include/session_start.php');
require_once ('../include/DB.php');
require_once ('../include/Chat.php');
require_once ('../include/User.php');

$user = new User();
if ($user->isLogin() !== true)
{
    echo $errorResponse = json_encode
    (
        array
        (   // lack input
            "status" => false,
            "message" => array
            (
                "errorCode" => -4,  // some thing to change with front
                "errorMessage" => "User not login.",
            ),
        )
    );
    exit(0);
}

if (@isset($_GET['action']))
{
    $action = $_GET['action'];
    if ($action === 'send')
    {
        $chat = new Chat();
        if (@isset($_POST['to']) && isset($_POST['message']) )
        {
            $to = $_POST['to'];
            $message = $_POST['message'];
            echo json_encode($chat->addMessage($user->getUsername(), $to, $message, date('Y-m-d H:i:s', time())));
            exit(0);
        }
        else
        {
            echo $errorResponse = json_encode
            (
                array
                (
                    "status" => false,
                    "message" => array
                    (
                        "errorCode" => -16,  // some thing to change with front
                        "errorMessage" => "No user for to or no message.",
                    ),
                )
            );
        }
    }
    else if ($action === 'get')
    {
        $chat = new Chat();
        if (@isset($_POST['to']))
        {
            $to = $_POST['to'];
            echo json_encode($chat->getMessage($user->getUsername(), $to));
            exit(0);
        }
        else
        {
            echo $errorResponse = json_encode
            (
                array
                (
                    "status" => false,
                    "message" => array
                    (
                        "errorCode" => -8,  // some thing to change with front
                        "errorMessage" => "the user for to is not find.",
                    ),
                )
            );
        }

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
                "errorCode" => -12,  // some thing to change with front
                "errorMessage" => "Nothing to do.",
            ),
        )
    );
}


