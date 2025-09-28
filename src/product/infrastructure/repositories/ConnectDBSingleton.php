<?php

namespace Src\product\infrastructure\repositories;

use MongoDB\Client;
use MongoDB\Database;

class ConnectDBSingleton
{
    private static ?self $instance = null;

    private function __construct() {
        $this->connect();
    }

    private function __clone() {}

    private function __wakeup() {}

    private Database $connect;

    private function connect() {
        $client = new Client(env('MONGODB_URI'));

        $database = $client->selectDatabase(env('MONGODB_DATABASE'));

        $this->connect = $database;
    }

    public function getConnect(): Database {
        return $this->connect;
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}
