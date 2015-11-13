<?php

/**
 * Created by PhpStorm.
 * User: lc4t
 * Date: 15-11-11
 * Time: 20:08
 */
require_once ('../include/session_start.php');
require_once ('../include/DB.php');
require_once ('../include/User.php');



class Chat
{

    function __construct()
    {


        try
        {
            $this->dbh = new PDO('mysql:host=' . HOST . ';dbname=' . DATABASE, USER, PASSWORD, array(
                PDO::ATTR_PERSISTENT => true));
        }
        catch (Exception $e)
        {
            if (DEBUG)
            {
                die("Unable to connect: " . $e->getMessage());
            }
            else
            {
                die();
            }
        }
    }
    private function execSQL($sql)
    {
        try
        {
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->dbh->beginTransaction();
            $this->dbh->exec($sql);
            $this->dbh->commit();
            return $response = array
                                (
                                    "status" => true,
                                );
        }
        catch (Exception $e)
        {
            $this->dbh->rollBack();

            if (DEBUG)
            {
                echo "Failed: " . $e->getMessage() . '<br \>';
                echo $e->getCode() . '<br \>';
            }
            else
            {
                //
            }

            $errorCode = $e->getCode();
            switch($errorCode)
            {

                default:
                    $errorArray = array
                    (
                        "status" => false,
                        "message" => array
                        (
                            "errorCode" => -1,
                            "errorMessage" => "Something wrong.",
                        ),
                    );

                    return $errorArray;

            }



        }
    }

    private function querySQL($sql)
    {
        try
        {
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $rs = $this->dbh->query($sql);
            $rs->setFetchMode(PDO::FETCH_ASSOC);

            $req = $rs->fetchAll();


            $successArray = array
            (
                "status" => true,   //login success
                "response" => $req,
            );

            return $successArray;
        }
        catch (Exception $e)
        {

            if (DEBUG)
            {
                echo "Failed: " . $e->getMessage() . '<br \>';
                echo $e->getCode() . '<br \>';
            }
            else
            {
                //
            }

            $errorCode = $e->getCode();
            switch($errorCode)
            {
//                case 42000: //Query was empty, means match error
//                {
//                    $errorArray = array
//                    (
//                        "status" => false,
//                        "message" => array
//                        (
//                            "errorCode" => $errorCode,  // some thing to change with front
//                            "errorMessage" => "username and password not match.",
//                        )
//                    );
//
//                    return $errorArray;
//                }
                default:
                    $errorArray = array
                    (
                        "status" => false,
                        "message" => array
                        (
                            "errorCode" => -1,
                            "errorMessage" => "Something wrong.",
                        ),
                    );

                    return $errorArray;

            }



        }


    }


    public function userExists($to)
    {
        try
        {
            $sql = sprintf("select 1 from `%s` where username='%s';", TABLE_USER, $to);

            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $rs = $this->dbh->query($sql);
            $rs->setFetchMode(PDO::FETCH_ASSOC);

            $req = $rs->fetchAll();

            if (count($req) !== 0)
            {
                return 1;
            }
            else
            {
                return 0;
            }


        }
        catch (Exception $e)
        {

            if (DEBUG)
            {
                echo "Failed: " . $e->getMessage() . '<br \>';
                echo $e->getCode() . '<br \>';
            }
            else
            {
                //
            }

            $errorCode = $e->getCode();
            switch($errorCode)
            {

                default:
                    $errorArray = array
                    (
                        "status" => false,
                        "message" => array
                        (
                            "errorCode" => -1,
                            "errorMessage" => "Something wrong.",
                        ),
                    );

                    return $errorArray;

            }
        }


    }


    public function addMessage($from, $to, $message, $postTime)
    {
        //the message must htmlspecialchars

        $message = htmlspecialchars($message, ENT_QUOTES);
        if (@$this->userExists($to) === 0)
        {
            return array
                    (
                        "status" => false,
                        "message" => array
                        (
                            "errorCode" => -24,  // some thing to change with front
                            "errorMessage" => "No this user.",
                        ),
                    );
        }
        $sql = sprintf("insert into `%s` (`from`, `to`, `message`, `time`) values ('%s', '%s', '%s', '%s');", TABLE_MESSAGE, $from, $to, $message, $postTime);
        $response = $this->execSQL($sql);
        return $response;
    }

    public function getMessage($from, $to, $startTime)
    {
        //WARNING : get time by '>' is slow, should use UNIX TIME
        $sql = sprintf("select id,message,time from %s where `from`='%s' and `to`='%s' and time>'%s';", TABLE_MESSAGE, $from, $to, $startTime);
//        echo $sql;exit(0);

        $response = $this->querySQL($sql);
//        print_r($response);
        //TODO: select by time,return json
        return $response;
    }

    function __destruct()
    {
        $this->dbh = null;
    }


}