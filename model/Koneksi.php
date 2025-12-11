<?php
class Koneksi {

    private $host;
    private $user;
    private $password;
    private $dbname;
    private $port;

    public $conn;

    public function __construct() {

        // Gunakan variabel dari Railway
        $this->host     = getenv('MYSQLHOST');
        $this->user     = getenv('MYSQLUSER');
        $this->password = getenv('MYSQLPASSWORD');
        $this->dbname   = getenv('MYSQLDATABASE');
        $this->port     = getenv('MYSQLPORT');

        // Koneksi dengan port wajib
        $this->conn = new mysqli(
            $this->host,
            $this->user,
            $this->password,
            $this->dbname,
            $this->port
        );

        if ($this->conn->connect_error) {
            die('Koneksi gagal: ' . $this->conn->connect_error);
        }

        $this->conn->set_charset('utf8mb4');
    }

    public function getConnection() {
        return $this->conn;
    }
}

$koneksi = new Koneksi();
?>