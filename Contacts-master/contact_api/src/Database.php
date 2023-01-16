<?php
class Database
{
    private $database = "contact";
    private $host = "127.0.0.1";
    private $username = "root";
    private $password = "";

    private $maxPool = 10;
    public $connectionPool = [];

    function __construct()
    {
        // Melakukan perulangan sebanyak $maxPool
        for ($i = 0; $i < $this->maxPool; $i++) {

            // Membuat koneksi database
            $conn = new mysqli($this->host, $this->username, $this->password, $this->database);

            // Jika terjadi error, maka ...
            if ($conn->connect_error) {
                die("Connection  Failed: " . $conn->connect_error);
            }

            // Koneksi yang berhasil dibuat, dimasukkan kedalam array $connectionPool
            array_push($this->connectionPool, $conn);
        }


        // Menyiapkan tabel
        $this->makeTables();
    }

    // Mengambil koneksi database dari $connectionPool
    function connect()
    {
        return array_shift($this->connectionPool);
    }

    // Menutup/Mengembalikan koneksi dari database ke $conectionPool
    function close($conn)
    {
        array_push($this->connectionPool, $conn);
    }

    // Menyiapkan tabel didalam database
    private function makeTables()
    {
        $conn = $this->connect();

        $sql = "CREATE TABLE IF NOT EXISTS contact (
            id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
            name TEXT NOT NULL,
            email TEXT NOT NULL,
            phone TEXT NOT NULL,
            img TEXT DEFAULT NULL
        );";

        if ($conn->query($sql) != TRUE) {
            echo "Error creating table: " . $conn->error;
        }

        $this->close($conn);
    }
}

$db = new Database();