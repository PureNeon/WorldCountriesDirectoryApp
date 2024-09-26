<?php

namespace App\Rdb;

use mysqli;
use RuntimeException;
use DateTime;
use Exception;

class SqlHelper{

    public function __construct() {
        $this->pingDb();
    }

    private function pingDb() : void {
        $connection = $this->openDbConnection();
        $connection->close();
    }
    public function openDbConnection(): mysqli  {
        $connection = new mysqli(
            hostname: $_ENV["SqlHost"],
            port: $_ENV["SqlPort"], 
            username: $_ENV["SqlUser"], 
            password: $_ENV["SqlPassword"], 
            database: $_ENV["SqlDatabase"],
        );
        if ($connection->connect_errno) {
            throw new RuntimeException(message: "Failed to connect to MySQL: ".$connection->connect_error);
        }
        return $connection;
    }
}