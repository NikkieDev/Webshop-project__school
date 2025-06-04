<?php

declare(strict_types=1);

abstract class BaseRepository
{
    private string $serv = '127.0.0.1';
    private string $dbName = 'shop';
    private string $user = 'root';
    private string $pass = 'password';

    private ?PDO $conn = null;

    private function connect()
    {
        try {
            $this->conn = new PDO("mysql:host=" . $this->serv . ";dbname=" . $this->dbName, $this->user, $this->pass);
        } catch (PDOException $e) {
            die("Unable to log into database, " . $e->getMessage());
        }
    }

    protected function getConnection()
    {
        if (!$this->conn) {
            $this->connect();
        }

        return $this->conn;
    }

    private function disconnect()
    {
        $this->conn = null;
    }

    protected function generateUUID(): string
    {
        $this->getConnection();
        return $this->conn->query("SELECT UUID()")->fetchColumn();
    }
}