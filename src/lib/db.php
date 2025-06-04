<?php

declare(strict_types=1);

require_once "model/UserType.php";

class Db
{
    private string $server = "127.0.0.1";
    private string $dbName = "shop";
    private string $user = "root";
    private string $pass = "password";

    private PDO|null $conn;

    public function __construct()
    {
        try {
            $this->conn = new PDO("mysql:host=" . $this->server . ";dbname=" . $this->dbName, $this->user, $this->pass);
        } catch (PDOException $e) {
            echo "Couldn't log into database" . $e;
        }
    }
}