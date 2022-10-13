<?php
class Connection
{
    public function connect()
    {
        $host       = 'localhost';
        $username   = 'root';
        $password   = '';
        $dbname     = 'coba_apriori';
        $conn = mysqli_connect($host, $username, $password, $dbname);
        return $conn;
    }
}


