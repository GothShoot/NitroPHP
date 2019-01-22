<?php

namespace Module\DatabaseModule\Services;

use Module\CoreModule\BaseClass\Singleton;

class PdoHandler extends Singleton
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = $this->sqlConnect();
    }

    private function sqlConnect()
    {
        global $dbhost, $dbuser, $dbpass, $dbname;
        $dbh = new PDO('mysql:host='.$dbhost.';dbname='.$dbname, $dbuser, $dbpass, array(
            PDO::ATTR_PERSISTENT => true
        ));
    }

    public function query($sql)
    {

    }
}