<?php

namespace config;

class Database {
    private $host = "localhost";
    private $db = "lending_db";
    private $user = "root";
    private $pass = "";
    public $conn;

    public function connect() {
        $this->conn = null;

        try {
            // Use the global namespace for PDO
            $this->conn = new \PDO(
                "mysql:host={$this->host};dbname={$this->db}",
                $this->user,
                $this->pass
            );
            $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            die("Database Error: " . $e->getMessage());
        }

        return $this->conn;
    }
}

?>