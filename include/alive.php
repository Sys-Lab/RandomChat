<?php

/**
 * Created by PhpStorm.
 * User: lc4t
 * Date: 15-11-14
 * Time: 1:43
 */
class Alive
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

    function autoDelete()
    {
        // Must : add this to else function's end
        // Notice : Ajax add to every page, keep visit
        $sql = sprintf("DELETE FROM Person WHERE `time` < '%s' ;",TABLE_ALIVE, date('Y-m-d H:i:s', strtotime('-5 minute')));
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
            return false;
        }
    }

    function updateAlive($sessionid, $updateTime, $username)
    {
        $sql = sprintf("DELETE FROM Person WHERE `time` < '%s' ;",TABLE_ALIVE, date('Y-m-d H:i:s', strtotime('-5 minute')));
    }
}