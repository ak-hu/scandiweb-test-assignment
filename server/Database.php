<?php
namespace App;
  class Database {
    private $host = 'localhost';
    private $user = 'root';
    private $password = 'root';
    private $dbName = 'scandiweb_products';
    private $connection;

    public function connect() {
        $this->connection = new \mysqli($this->host, $this->user, $this->password, $this->dbName);

        if ($this->connection->connect_error) {
            die('Connection failed: ' . $this->connection->connect_error);
        }

        return $this->connection;
    }

    public function closeConnection() {
        if ($this->connection) {
            $this->connection->close();
        }
    }
}
?>
