<?php

class Database {
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "cowork_reservations";
    private $port = 3306; // Promeni ako koristiš drugi port

    public $conn;

    public function __construct() {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database, $this->port);

        if ($this->conn->connect_error) {
            die("Greška pri povezivanju sa bazom: " . $this->conn->connect_error);
        }
    }
}

?>
