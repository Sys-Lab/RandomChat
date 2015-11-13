<?php
/**
 * Created by PhpStorm.
 * User: lc4t
 * Date: 15-11-13
 * Time: 23:51
 */

require_once('../include/Chat.php');


if (@isset($_POST['user']))
{
    $judge = new Chat();
    $raw_username = $_POST['user'];
    if (@preg_match("/^[_a-zA-Z0-9]{3,15}$/",$raw_username))
    {
        if ($judge->userExists($raw_username) === 1)
        {
            echo json_encode
            (
                array
                (
                    "status" => true,
                    "message" => array
                    (
                        "Code" => -200,  // some thing to change with front
                        "Message" => "username exists.",
                    ),
                )
            );
        }
        else
        {
            echo json_encode
            (
                array
                (
                    "status" => false,
                    "message" => array
                    (
                        "Code" => -202,  // some thing to change with front
                        "Message" => "username not exists.",
                    ),
                )
            );
        }

    }
    else
    {
        echo json_encode
        (
            array
            (
                "status" => false,
                "message" => array
                (
                    "errorCode" => -204,  // some thing to change with front
                    "errorMessage" => "username input error.",
                ),
            )
        );
    }
}
else
{
    echo json_encode
    (
        array
        (
            "status" => false,
            "message" => array
            (
                "errorCode" => -206,  // some thing to change with front
                "errorMessage" => "No input.",
            ),
        )
    );
}
