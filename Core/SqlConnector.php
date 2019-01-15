<?php

namespace Core;

class SqlConnector
{
    public function sqlConnect()
    {
        global $dbhost, $dbuser, $dbpass, $dbname;
        $dbh = new PDO('mysql:host='.$dbhost.';dbname='.$dbname, $dbuser, $dbpass, array(
            PDO::ATTR_PERSISTENT => true
        ));
    }
}