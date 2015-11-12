<?php
// ok ok, just a test, if you want to hack this vps, just go on.
// There is the connection args...
    define('DEBUG',true);
    if (DEBUG)
    {
        define('HOST', '115.29.110.218');
    }
    else
    {
        define('HOST', 'localhost');
    }
    define('DATABASE', 'randomchat');
    define('USER', 'randomchat');
    define('PASSWORD', 'RandomChat');
    define('TABLE_USER', 'user');
    define('TABLE_AlLIVE', 'alive');
    define('TABLE_MESSAGE', 'message');

    date_default_timezone_set("PRC");
?>