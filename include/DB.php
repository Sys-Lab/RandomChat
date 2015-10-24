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
                    return "username was exists";
                }

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
//        echo $sql;
//        exit(0);
        if (($status = $this->execSQL($sql)) !== true)
        {
            //There is return to user
            echo $status;
        }
    }

    function __destruct()
    {
        $this->dbh = null;
    }

}



//select FROM_UNIXTIME(time());

?>