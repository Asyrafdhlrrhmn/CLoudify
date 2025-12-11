<?php
class koneksi {

    private $host;
    private $user;
    private $password;
    private $dbname;

    public $conn;

    public function __construct() {

        $this->host     = getenv('DB_HOST');
        $this->user     = getenv('DB_USER');
        $this->password = getenv('DB_PASS');
        $this->dbname   = getenv('DB_NAME');

        $this->conn = new mysqli($this->host, $this->user, $this->password, $this->dbname);

        if ($this->conn->connect_error) {
            die('Koneksi gagal: ' . $this->conn->connect_error);
        }

        $this->conn->set_charset('utf8mb4');
    }

    public function getConnection() {
        return $this->conn;
    }
}

$koneksi = new koneksi();
?>
