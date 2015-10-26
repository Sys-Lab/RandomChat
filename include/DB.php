<?php
/**
 * Created by PhpStorm.
 * User: lc4t
 * Date: 10/23/15
 * Time: 8:43 PM
 */

require_once ('config.inc.php');

class DB
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

    public function filter($raw_input)
    {
        $input = $raw_input;
        return $input;
    }

    public function execSQL($sql)
    {
        try
        {
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->dbh->beginTransaction();
            $this->dbh->exec($sql);
            $this->dbh->commit();
            return true;
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
                case 23000:
                {
                    $errorArray = array
                    (
                        "status" => false,
                        "message" => array
                        (
                        "errorCode" => $errorCode,  // some thing to change with front
                        "errorMessage" => "username was exists.",
                        )
                    );
//                    $errorResponse = json_encode($errorArray);
//                    return $errorResponse;
                    return $errorArray;
                }
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
//                    $errorResponse = json_encode($errorArray);
//                    return $errorResponse;
                    return $errorArray;

            }



        }
    }

    public function addUser($raw_username, $raw_password, $raw_sex, $raw_email, $postTime)
    {
        $username = $this->filter($raw_username);
        $password = $this->filter($raw_password);
        $sex      = $this->filter($raw_sex);
        $email    = $this->filter($raw_email);
        $sql = sprintf("insert into `%s` (username, password, sex, email, regist_time, last_login_time) values ('%s', aes_encrypt('%s', '%s'), '%s', '%s', '%s', '%s');", TABLE_USER, $username, $password, $password, $sex, $email, $postTime, $postTime);

        try
        {
            // add a user,
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->dbh->beginTransaction();
            $this->dbh->exec($sql);
            $this->dbh->commit();
            $successArray = array
            (
                "status" => true,
                "message" => array
                (
                "username" => $username,  // some thing to change with front
                "sex" => $sex,
                "email" => $email,
                ),
            );
//            $successResponse = json_encode($successArray);
//            return $successResponse;
            return $successArray;

        }
        catch (Exception $e)
        {
            // if something wrong, there is deal with it
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
                case 23000:
                {
                    $errorArray = array
                    (
                        "status" => false,
                        "message" => array
                        (
                        "errorCode" => $errorCode,  // some thing to change with front
                        "errorMessage" => "username was exists.",
                        ),
                    );
//                    $errorResponse = json_encode($errorArray);
//                    return $errorResponse;
                return $errorArray;
                }
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
//                    $errorResponse = json_encode($errorArray);
//                    return $errorResponse;
                return $errorArray;

            }



        }
    }

    public function loginUser($raw_username, $raw_password, $postTime)
    {
        $username = $this->filter($raw_username);
        $password = $this->filter($raw_password);

        $sql = sprintf("select sex,email from `%s` where username='%s' and password=aes_encrypt('%s', '%s')", TABLE_USER, $username, $password, $password, $password);
        try
        {
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $rs = $this->dbh->query($sql);
            $rs->setFetchMode(PDO::FETCH_ASSOC);

            $req = $rs->fetchAll();
//            print_r($req);
//            exit();
            $sex = $req[0]['sex'];
            $email = $req[0]['email'];
//            exit(0);
//            if ($req === 1)
//            {
            $successArray = array
            (
                "status" => true,   //login success
                "message" => array
                (
                    "username" => $username,  // some thing to change with front
                    "sex" => $sex,
                    "email" => $email,
                ),
            );

            return $successArray;
//            }
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
                case 42000: //Query was empty, means match error
                {
                    $errorArray = array
                    (
                        "status" => false,
                        "message" => array
                        (
                            "errorCode" => $errorCode,  // some thing to change with front
                            "errorMessage" => "username and password not match.",
                        )
                    );

                    return $errorArray;
                }
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






    function __destruct()
    {
        $this->dbh = null;
    }

}




?>