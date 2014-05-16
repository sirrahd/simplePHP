<?php

// Great guide here: http://wiki.hashphp.org/PDO_Tutorial_for_MySQL_Developers

class DB
{
    private static $dbConnection = null;

    private function DB()
    {

    }

    static function connect()
    {
        global $dbhost, $dbuser, $dbpass, $dbname;

        if (!DB::$dbConnection)
        {
           DB::$dbConnection = new PDO(
                "mysql:host=$dbhost;dbname=$dbname;charset=utf8",
                "$dbuser",
                "$dbpass",
                array(
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                )
           );
        }

        return DB::$dbConnection;
    }
}
